<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * job model
 *
 * @author vamakin
 */
class Job extends Model {

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill');
    }
    
    public function verifiedSkills()
    {
        return $this->belongsToMany('App\Models\VerifiedSkill');
    }

}

?>