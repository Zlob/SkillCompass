<?php

namespace App\Helpers;

use App\Models\Skill;
use App\Models\Job;

/**
 * Parse HeadHunter jobs
 *
 * @author vamakin
 */
class HeadHunterParser
{

    /**
     * клиент для выполнения запросов к API
     * @var \Guzzle\Service\Client
     */
    private $client;

    /**
     * Дата начала парсинга
     * @var
     */
    private $parseDate;

    /**
     * Конструктор
     */
    public function __construct()
    {
//         phpinfo();
//         set_time_limit(6000);
        $this->client = new \Guzzle\Service\Client('https://api.hh.ru');
        $this->client->setUserAgent( 'SkillPricer/1.0 (vamakin@gmail.com)');
        $this->parseDate = date('Y-m-d');
    }

    /**
     * Старт парсинга API
     */
    public function parse()
    {
//        $this->clearDB(); // todo only for testing
        $jobs = $this->findJobs();
        foreach ($jobs as $jobId) {
            $this->parseJob($jobId);
        }
    }

    /**
     * Поиск всех подходящих вакансий
     *
     * @return array
     */
    public function findJobs()
    {
        $result = [];

        //todo для всех регионов РФ
        $specialization = '1.221';  //программирование и разработка
        $area = 2;            //регион СПБ
        $only_with_salary = true; //только с указанием зарплаты
        $currency = 'RUR'; //валюта      

        //итерация по страницам
        for ($page = 0; $page < 100; $page++) {

            $query = ['query' =>
                [
                    'specialization' => $specialization,
                    'area' => $area,
                    'only_with_salary' => $only_with_salary,
                    'currency' => $currency,
                    'page' => $page
                ]
            ];

            $jobsPage = $this->getRequestData('vacancies', $query);
            foreach ($jobsPage['items'] as $job) {
                $result[] = $job['id'];
            }
//             sleep(3);
        }
        return $result;
    }

    /**
     * Парсинг конкретной вакансии
     *
     * @param $jobId - идентификатор вакансии в HH
     */
    public function parseJob($jobId)
    {
        //получаем данные вакансии
        $data = $this->getRequestData("vacancies/$jobId", []);
        if ($data['salary']['currency'] !== 'RUR') { //повторная проверка валюты
            return;
        }

        //сохраняем вакансию в бд
        $job = new Job();
        $job->url = $data['alternate_url'];
        $job->cost = $this->getCost($data['salary']['from'], $data['salary']['to']);
        $job->area_id = $data['area']['id'];
        $job->parse_date = $this->parseDate;

        $job->save();

        //сохраняем ключевые навыки, указанные в вакансии
        foreach ($data['key_skills'] as $keySkill) {
            $skill = $this->getSkill($keySkill['name'], 1);
            $job->skills()->attach($skill);
        }

        //ищем ключевые навыки по тексту вакансии
        $vacancy_skills = $this->getVacancySkills($data['description']);
        if (count($vacancy_skills) <= 20) { //если нашлось больше 20 - вероятно вакансия на английском -> игнорируем
            //сохраняем найденные ключевые вакансии
            foreach ($vacancy_skills as $keySkill) {
                $skill = $this->getSkill($keySkill, 0);
                $job->skills()->attach($skill);
            }
        }
    }

    /**
     * Очистка БД перед парсингом - временная мера
     */
//     public function clearDB()
//     {
//         Job::where('id', '>', 0)->delete();
//     }

    /**
     * Ищет навык в БД или создает новый
     *
     * @param $skillName
     * @param $is_original
     * @return Skill
     */
    public function getSkill($skillName, $is_original)
    {
        //ищем скилл с таким же именем
        $skill = Skill::where('name', $skillName)->first();
        //если не нашли - добавляем ( только ключевые)
        if (!$skill && $is_original === 1) {
            $skill = new Skill();
            $skill->name = $skillName;
            $skill->save();
        }
        return $skill;
    }

    /**
     * Выполняет запрос к API и возвращает json ответа
     *
     * @param $api
     * @param array $options
     * @return mixed
     */
    public function getRequestData($api, array $options = [])
    {
        $headers = [];
        $response = $this->client->get($api, $headers, $options)->send(); //todo catch exception
        //todo throw exception if status != 200 and log it
        $result = json_decode($response->getBody(), true);
        return $result;
    }

    /**
     * Считает среднюю зарплату вакансии
     *
     * @param $from
     * @param $to
     * @return float
     */
    public function getCost($from, $to)
    {
        if ($from && $to) {
            return ($from + $to) / 2;
        }
        return $from ?: $to;
    }

    /**
     * Анализирует текст вакансии на предмет ключевых навыков
     *
     * @param $description
     * @return array
     */
    public function getVacancySkills($description)
    {
        $description = htmlspecialchars_decode(strip_tags($description));
        $re = '/(\w+\s\w+|\w+)/';
        preg_match_all($re, $description, $matches);
        $result = [];
        foreach ($matches[0] as $key => $value) {
            if (!is_numeric(trim($value))) {
                $result[] = $value;
            }
        }
        return $result;
    }

}

?>