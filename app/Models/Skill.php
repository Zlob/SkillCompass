<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model   
{
    protected $fillable = ['name'];    
    
    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job');
    }
    
    public function verifiedSkill()
    {
        return $this->belongsTo('App\Models\VerifiedSkill');
    }
    
    /**
     * Ищет навык в БД или создает новый
     *
     * @param $skillName
     * @param $is_original
     * @return Skill
     */
    public static function getOrCreateSkillByName($skillName, $is_original)
    {
        //ищем скилл с таким же именем
        $skill = self::where('name', $skillName)->first();
        //если не нашли - добавляем ( только ключевые)
        if (!$skill && $is_original) {
            $skill = Skill::create(['name' => $skillName]);
        }
        return $skill;
    }
      
    
    
}
