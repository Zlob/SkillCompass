<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * job model
 *
 * @author vamakin
 */
class Job extends Model {   
    
    protected $fillable = ['url', 'cost', 'area_id', 'parse_date', 'begda', 'endda', 'vacancy_id'];    

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