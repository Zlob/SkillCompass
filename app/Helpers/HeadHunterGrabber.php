<?php

    namespace App\Helpers;


    use Guzzle\Http\Exception\RequestException;

    /**
     * Итератор по вакансиям HeadHunter
     * Class HeadHunterGrabber
     * @package App\Helpers
     */
    class HeadHunterGrabber extends Grabber
    {

        /**
         * получение списка id вакансий
         * @return array
         */
        protected function getVacancies()
        {
            $result = [];

            $areas = [1, 2]; //Москва и Питер

            //итерация по городам
            foreach ($areas as $area) {
                //итерация по страницам
                for ($page = 0; $page < 100; $page++) {

                    $query = [
                        'query' => [
                            'specialization'   => '1.221',  //программирование и разработка
                            'only_with_salary' => true,   //только с указанием зарплаты
                            'currency'         => 'RUR',          //валюта
                            'area'             => $area,
                            'text'             => 'web OR веб OR forntend OR backend OR JavaScript OR PHP OR HTML OR CSS',
                            'page'             => $page
                        ]
                    ];

                    $jobsPage = $this->getRequestData('vacancies', $query);
                    if (count($jobsPage['items']) === 0) {
                        break;
                    }
                    foreach ($jobsPage['items'] as $job) {
                        $result[] = $job['id'];
                    }
                }
            }

            return $result;

        }



        /**
         * Возвращает данные о вакансии
         * @param $jobId
         * @return array|void
         */
        public function getVacancyDetails($jobId)
        {
            //получаем данные вакансии
            $data = $this->getRequestData("vacancies/$jobId", []);

            $vacancyData = [];

            $currentDate               = date('Y-m-d');
            $vacancyData['url']        = $data['alternate_url'];
            $vacancyData['cost']       = $this->getCost($data['salary']['from'], $data['salary']['to'], $data['salary']['currency']);
            $vacancyData['area_id']    = $data['area']['id'];
            $vacancyData['name']       = $data['name'];
            $vacancyData['parse_date'] = $currentDate;
            $publichedDate             = new \DateTime($data['published_at']);
            $vacancyData['begda']      = $publichedDate->format('Y-m-d');
            $vacancyData['endda']      = $currentDate;
            $vacancyData['vacancy_id'] = $jobId;

            $result                  = [];
            $result['vacancy_data']  = $vacancyData;
            $result['key_skills']    = $data['key_skills'];
            $result['parsed_skills'] = $this->getVacancySkillsFromText($data['description']);

            return $result;
        }

        /**
         * Считает среднюю зарплату вакансии
         *
         * @param $from
         * @param $to
         * @return float
         */
        public function getCost($from, $to, $currancy)
        {
            $cost = 0;
            if ($from && $to) {
                $cost = ($from + $to) / 2;
            }
            else{
                $cost = $from ?: $to;
            }
            if($currancy === 'USD'){
                $cost = $cost * 60;
            }

            return $cost;
        }

        /**
         * Анализирует текст вакансии на предмет ключевых навыков
         *
         * @param $description
         * @return array
         */
        public function getVacancySkillsFromText($description)
        {
            $description = htmlspecialchars_decode(strip_tags($description));
            $re          = '/(\w+\s\w+|\w+)/';
            preg_match_all($re, $description, $matches);
            $result = [];
            foreach ($matches[0] as $key => $value) {
                if (!is_numeric(trim($value))) {
                    $result[] = $value;
                }
            }
            $maxLength = 20;
            if (count($result) > $maxLength) { //если больше 20 навыков - игнорируем вакансию
                return [];
            } else {
                return $result;
            }
        }
    }
