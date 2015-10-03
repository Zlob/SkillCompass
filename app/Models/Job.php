<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * job model
 *
 * @author vamakin
 */
class Job extends Model {   
    
    protected $fillable = ['url', 'cost', 'name', 'area_id', 'parse_date', 'begda', 'endda', 'vacancy_id'];    

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill');
    }
    
    public function verifiedSkills()
    {
        return $this->belongsToMany('App\Models\VerifiedSkill');
    }
    
    public static function getJobByVacancyId($id) 
    {
        return self::where('vacancy_id', $id)->first();
    }
    
     /**
     * создает в бд новую вакансию из массива
     *
     * @param $vacancyInfo - массив с параметрами
     */ 
    public static function createJobWithSkills(array $vacancyInfo) 
    {
        $job = Job::create($vacancyInfo['vacancy_data']);
        foreach ($vacancyInfo['key_skills'] as $keySkill) {
            $job->attachSkill($keySkill['name'], true);
        }
        foreach ($vacancyInfo['parsed_skills'] as $keySkill) {
            $job->attachSkill($keySkill, false);
        }
        return $job;
    }
    

    /**
     * получает  массив вакансий за пол года, содержащих хотябы один навык из перечисленных
     *
     * @param $skillIds - массив навыков
     * @param $areaId - регион
     */  
    public static function getJobWithSkills($skillIds, $areaId)
    {
        $currentDate = new \DateTime();
        $halfYear = new \DateInterval('P3M');
        $date = $currentDate->sub($halfYear)->format('Y-m-d');
        $jobs = Job::with(['verifiedSkills' => function($query) use ($skillIds)
                           {
                               $query->whereNotIn('verified_skills.id', $skillIds);
                           }
                          ])
            ->where('area_id', $areaId)
            ->where('endda', '>=', $date)
            ->whereHas('verifiedSkills', function ($query) use ($skillIds) 
                       {
                           $query->whereIn('verified_skills.id', $skillIds);
                       }
                      )
            ->get();
        
        $groups = [];
        foreach($jobs as $job){
            $groups[$job->getGroupName($skillIds)][] = $job->toGroupElement();
        }
        $result = [];
        foreach($groups as $groupName => $group){
            $result[] = Job::getGroupAggregation($groupName, $group);
        }
        return $result;        
    }
    
    private static function getGroupAggregation($groupName, $group)
    {
        usort($group, function($a, $b){
            if ($a['cost'] === $b['cost']) {
                return 0;
            }
            return ($a['cost'] > $b['cost']) ? 1 : -1;
        });

        $aggregation = [];
        $aggregation['name'] = $groupName;
        $aggregation['min'] = $group[0]['cost'];
        $aggregation['max'] = end($group)['cost'];
        $aggregation['mid'] = $group[floor((count($group)-1)/2)]['cost'];
        $aggregation['total_count'] = count($group);
        $active_jobs = array_filter($group, function($groupItem) {return $groupItem['actual'] === true; });
        $aggregation['actual_count'] = count($active_jobs);
        $result = [];
        $result['aggregation'] = $aggregation;
        $result['actual_jobs'] = $active_jobs;
        return $result;
    }
    
    /**
     * формирует общее имя для группы навыков
     *
     * @param $excludeSkillIds - массив навыков
     */  
    public function getGroupName($excludeSkillIds)
    {
        return $this->verifiedSkills
            ->sort(function($a, $b)
                   {
                       if ($a->id === $b->id) {
                           return 0;
                       }
                       return ($a->id > $b->id) ? 1 : -1;
                   }
                  )
            ->reduce( function($carry, $skill) 
                     {
                         return $carry === "" ? $skill['name'] : $carry." ".$skill['name'];
                     }, "");
    }
    
    /**
     * приводит вакансию к нужному массиву
     *
     */ 
    public function toGroupElement()
    {
        return [
            'id'     => $this->id,
            'cost'   => $this->cost,
            'url'    => $this->url,
            'actual' => $this->getActual(),  
            'additional_skills_count' => $this->verifiedSkills->count()
        ]; 
    }
    
    /**
     * проверяет, является ли вакансия актуальной
     *
     */
    private function getActual()
    {
        $currentDate = new \DateTime();
        $threeDays = new \DateInterval('P3D');
        $date = $currentDate->sub($threeDays)->format('Y-m-d');
        if($this->endda >= $date){
            return true;
        }
        else{
            return false;
        }
    }       
    
    /**
     * Связывает вакансию с навыками
     *
     * @param $job - модель вакансии
     * @param $skillName - навык
     * @param $is_original - навык является ключевым
     */    
    public function attachSkill($skillName, $is_original)
    {
        $skill = Skill::getOrCreateSkillByName($skillName, $is_original);
        $this->skills()->attach($skill);             
        if($skill && $skill->verifiedSkill){
            if( !$this->verifiedSkills()->find( $skill->verifiedSkill->id) ){
                $this->verifiedSkills()->attach($skill->verifiedSkill);   
            }
        }
    } 
    
    /**
     * Продление срока вакансии
     *
     * @param $job - модель вакансии
     */
    public function extendJob() 
    {
        $this->endda = date('Y-m-d');
        $this->save();
    }
}

?>