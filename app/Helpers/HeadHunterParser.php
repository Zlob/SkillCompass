<?php

namespace App\Helpers;

use App\Models\job;

/**
 * Parse HeadHunter jobs
 *
 * @author vamakin
 */
class HeadHunterParser {
    private $client;
    
    public function __construct()
    {
        $this->client = new \Guzzle\Service\Client('https://api.hh.ru');
    }
    
    
    public function parse()
    {
        $jobs = $this->findJobs();
        foreach($jobs as $jobId){
            $job = $this->parseJob($jobId);
        }
    }    
    
    public function findJobs()
    {          
        $result = [];
        
        //todo для всех регионов РФ
        $specialization = 1;  //специализация - IT
        $area = 2;            //регион СПБ
        $only_with_salary = true; //только с указанием зарплаты
        $currency = 'RUR'; //валюта      

        //итерация по страницам
        for($page = 0; $page < 1; $page++){ //todo 1 -> 100  
            
            $query = ['query' => 
                      [            
                          'specialization' => $specialization,
                          'area' => $area,
                          'only_with_salary' => $only_with_salary,
                          'currency' => $currency,
                          'page' => $page
                      ]
                     ];   
            
            $jobsPage =  $this->getRequestData("vacancies", $query);
            foreach($jobsPage['items'] as $job){
                $result[] = $job['id'];
            } 
        }
        return $result;
    }
    
    public function parseJob($jobId)
    {
        //get job data
        $data = $this->getRequestData("vacancies/$jobId", []);
        //prepare job data

        
        $job = new \App\Models\job();
        
        $result = [];
        $job->url = $data['alternate_url'];
        $job->cost = $this->getCost($data['salary']['from'], $data['salary']['to']);
        $job->area_id = $data['area']['id'];
//         $job->key_skills = $data['key_skills'];
//         $job->vacancy_skills =$this->getVacancySkills($data['description']);
        $job->save();
        
//         return $result;
    }
    
    public function getRequestData($api, $options = [])
    {
        $headers = [];//todo send headers
        $response = $this->client->get($api, $headers, $options)->send();
        //todo throw exception if status != 200
        $job = json_decode($response->getBody(), true);
        return $job;
    }
    
    public function getCost($from, $to){
        if($from && $to){
            return ($from + $to)/2;
        }        
        return $from ? $from : $to;
    }
    
    public function getVacancySkills($description)
    {
        $description = htmlspecialchars_decode(strip_tags($description)) ;
        $re = "/(\w+\s\w+|\w+)/"; 
        preg_match_all($re, $description, $matches);
        $result = [];
        foreach($matches[0] as $key=>$value){
            if(!is_numeric(trim($value))){
                $result[] = $value;
            }
        }
        return $result;
    }
    
}

?>