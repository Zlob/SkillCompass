<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use DB;
use Input;
use App\Helpers\JobsGrouperator\JobsGrouperator;

class ChartController extends Controller
{
    
    public function getStatisticInfo()
    {
        $skills_ids = Input::get('skills_ids');
        $areaId = Input::get('areaId');
        $result  = [];
        foreach($skills_ids as $skillId){
            $result[$skillId]['popular_chart_info'] = $this->getPopularChart($skillId, $areaId);
            $result[$skillId]['related_chart_info'] = $this->getRelatedChart($skillId, $areaId);
        }
        return $result;        
    }
    
    
    private function getPopularChart($id, $areaId)
    {
        //получаем даты
        $dates = $this->getDates(); 
        $result = [];
        //считаем для каждой даты статистику
        foreach($dates as $date){
            $countInMonth = DB::table('job_verified_skill')
                ->join('jobs', 'job_verified_skill.job_id', '=', 'jobs.id')
                ->where('verified_skill_id', $id)
                ->where('begda', '<=', $date['date'])
                ->where('endda', '>=', $date['date'])
                ->where('area_id', $areaId)
                ->count();
            $item['total_count'] = $countInMonth;
            $item['name'] = $date['name'];
            $result[] = $item;
        }
        return $result;
    }
    
    
    private function getRelatedChart($id, $areaId)
    {
        //получаем все скиллы
        $skills_ids = DB::table('skills')->where('verified_skill_id', $id)->lists('id');
        if (!$skills_ids) {
            //todo exception  
        }
        
        //получаем все вакансии с этим скилом
        $job_ids = DB::table('job_skill')->whereIn('skill_id', $skills_ids)->lists('job_id');
        
        $jobs_count = count($job_ids);
        
        //получаем все скиллы вакансий
        $result = DB::table('job_verified_skill')
            ->leftJoin('verified_skills', 'job_verified_skill.verified_skill_id', '=', 'verified_skills.id')
            ->leftJoin('jobs', 'job_verified_skill.job_id', '=', 'jobs.id')
            ->select('verified_skills.name', DB::raw('count(verified_skills.id) as total_count'))
            ->whereIn('job_id', $job_ids)
            ->where('verified_skills.id', '!=', $id)
            ->where('area_id', $areaId)
            ->groupBy('verified_skills.id')  
            ->orderBy('total_count', 'desc')
            ->limit(15)
            ->get();
        
        foreach($result as $esultItem){
            $esultItem->total_count = $this->getPercentage($jobs_count, $esultItem->total_count);
        }
        
        return $result;    
    }
    
    public function getJobsBySkills(Job $job)
    {
        $skillIds = Input::get('skillIds');
        $areaId   = Input::get('areaId');

        $jobs = $job::getJobWithSkills($skillIds, $areaId);

        return $jobs;
       
    }    
    
    private function getPercentage($totalCount, $partCount, $precesion = 0) {
         return round (filter_var($partCount, FILTER_VALIDATE_INT) / $totalCount * 100, $precesion);
    }
    
    private function getDates()
    {
        $dates = [];      
        $oneMonth = new \DateInterval('P1M');
        $curentDate = new \DateTime();
        $MONTH_MIDDLE = 15;
        
        //если месяц не перевалил за середину, берем предидущий месяц
        if($curentDate->format('d') < $MONTH_MIDDLE){
            $curentDate->sub($oneMonth);
        }
        //ставим середину месяца
        $curentDate->setDate($curentDate->format('Y'), $curentDate->format('m'), $MONTH_MIDDLE);
        for($i = 0; $i < 12; $i++){
            $dateElem = [];
            $dateElem['date'] = $curentDate->format('Y-m-d');
            $dateElem['name'] = $curentDate->format('F');
            array_unshift($dates, $dateElem);
            $curentDate->sub($oneMonth);
        }             

        return $dates;
    }
    
    
}