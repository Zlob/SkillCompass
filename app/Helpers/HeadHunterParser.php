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
    private $currentDate;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->client = new \Guzzle\Service\Client('https://api.hh.ru');
        $this->client->setUserAgent( 'SkillPricer/1.0 (vamakin@gmail.com)');
        $this->currentDate = date('Y-m-d');
    }

    /**
     * Старт парсинга API
     */
    public function parse()
    {
        $this->parseJobsInArea(1); //Москва
        $this->parseJobsInArea(2); //Питер

    }
    
    public function parseJobsInArea($areaId)
    {
        $jobs = $this->findJobs($areaId);
        
        foreach ($jobs as $jobId) {
            
            $job = Job::where('vacancy_id', $jobId)->first();
            
            if ($job) {
                $this->updateJob($job);
            }
            else {
                $this->parseJob($jobId);
            }
        }        
    }

    /**
     * Поиск всех подходящих вакансий
     *
     * @return array
     */
    public function findJobs($area)
    {
        $result = [];

        //todo для всех регионов РФ
        $specialization = '1.221';  //программирование и разработка
        $only_with_salary = true; //только с указанием зарплаты
        $currency = 'RUR'; //валюта      

        //итерация по страницам
        for ($page = 0; $page < 100; $page++) { //todo to 100

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
        $job->parse_date = $this->currentDate;
        $publichedDate = new \DateTime($data['published_at']);
        $job->begda = $publichedDate->format('Y-m-d');
        $job->endda = $this->currentDate;
        $job->vacancy_id = $jobId;
        $job->save();

        //сохраняем ключевые навыки, указанные в вакансии
        foreach ($data['key_skills'] as $keySkill) {
            $this->attachSkill($job, $keySkill['name'], true);
        }

        //ищем ключевые навыки по тексту вакансии
        $vacancy_skills = $this->getVacancySkills($data['description']);
        if (count($vacancy_skills) <= 20) { //если нашлось больше 20 - вероятно вакансия на английском -> игнорируем
            //сохраняем найденные ключевые вакансии
            foreach ($vacancy_skills as $keySkill) {
                $this->attachSkill($job, $keySkill, false);
            }
        }
    }
  
     /**
     * Обновление вакансии
     *
     * @param $job - модель вакансии
     */
    public function updateJob($job) 
    {
        $job->endda = $this->currentDate;
        $job->save();
    }  
    
     /**
     * Связывает вакансию с навыками
     *
     * @param $job - модель вакансии
     * @param $skillName - навык
     * @param $is_original - навык является ключевым
     */    
    public function attachSkill($job, $skillName, $is_original)
    {
        $skill = $this->getSkill($skillName, $is_original);
        $job->skills()->attach($skill);             
        if($skill && $skill->verifiedSkill){
            if( !$job->verifiedSkills()->find( $skill->verifiedSkill->id) ){
                $job->verifiedSkills()->attach($skill->verifiedSkill);   
            }
        }
    }
      

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
        if (!$skill && $is_original) {
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