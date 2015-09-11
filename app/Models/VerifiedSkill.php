<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifiedSkill extends Model
{
    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job');
    }
}
