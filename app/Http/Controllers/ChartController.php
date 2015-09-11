<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Input;

class ChartController extends Controller
{
    /**
     * Show the specified photo comment.
     *
     * @param  int  $photoId
     * @param  int  $commentId
     * @return Response
     */
    public function getPopularChartInfo()
    {
//         $skills = Input::get('skills');
//         foreach($skills as $skill){
//             if($skill['checked'] != 'true'){
//                 continue;
//             }
//             //todo - реальные данны
//         }
        $data = [
            'labels' => ["January", "February", "March", "April", "May", "June", "July"],
            'datasets' => [
                    [
                        'label' => "My First dataset",
                        'fillColor' => "rgba(220,220,220,0.2)",
                        'strokeColor' => "rgba(220,220,220,1)",
                        'pointColor' => "rgba(220,220,220,1)",
                        'pointStrokeColor' => "#fff",
                        'pointHighlightFill' => "#fff",
                        'pointHighlightStroke' => "rgba(220,220,220,1)",
                        'data' => [65, 59, 80, 81, 56, 55, 40]
                    ]
                ]
        ];
        return $data;
    }
    
    public function getrelatedChartInfo()
    {
        $id = Input::get('id');
        $areaId = Input::get('areaId');
                
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
            ->join('verified_skills', 'job_verified_skill.verified_skill_id', '=', 'verified_skills.id')
            ->join('jobs', 'job_verified_skill.job_id', '=', 'jobs.id')
            ->select('verified_skills.name', DB::raw('count(verified_skills.id) as total_count'))
            ->whereIn('job_id', $job_ids)
            ->where('verified_skills.id', '!=', $id)
            ->where('area_id', $areaId)
            ->groupBy('verified_skills.id')  
            ->orderBy('total_count', 'desc')
            ->limit(15)
            ->get();
        
        return $result;
        
    }
    
    private function getPercentage($totalCount, $partCount, $precesion = 0) {
         return round (filter_var($partCount, FILTER_VALIDATE_INT) / $totalCount * 100, $precesion);
    }
}