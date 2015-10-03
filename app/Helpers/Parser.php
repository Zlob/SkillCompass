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
    private $job;

    /**
     * Конструктор
     */
    public function __construct(array $grabbers, Job $job)
    {
        $this->grabbers = $grabbers;
        $this->job = $job;
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
    
    public function parseVacancy( $vacancyId, $grabber)
    {
        $job = $this->job->getJobByVacancyId($vacancyId);
        if ($job) {
            $job->extendJob();
        }
        else {
            $vacancyInfo = $grabber->getVacancyDetails($vacancyId);
            $this->job->createJobWithSkills($vacancyInfo);                  
        }
    }
    
    
    
}
