<?php

namespace App\Helpers;

use App\Models\Job;

/**
 * Parse HeadHunter jobs
 *
 * @author vamakin
 */
class Parser
{
    private $grabbers = [];

    /**
     * Конструктор
     */
    public function __construct(array $grabbers)
    {
        $this->grabbers = $grabbers;
    }

    /**
     * Старт парсинга API
     */
    public function parse()
    {
        foreach( $this->grabbers as $grabber ) {
            foreach ($grabber as $vacancyId) {
                $this->parseVacancy($vacancyId, $grabber);
            }
        }
    }
    
    public function parseVacancy($vacancyId, $grabber)
    {
        $job = Job::getJobByVacancyId($vacancyId);
        if ($job) {
            $job->extendJob();
        }
        else {
            $vacancyInfo = $grabber->getVacancyDetails($vacancyId);
            Job::createJobWithSkills($vacancyInfo);                  
        }
    }
    
    
    
}
