<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VerifiedSkill;

class VerifiedSkillController extends Controller
{
    /**
     * Show the specified photo comment.
     *
     * @param  int  $photoId
     * @param  int  $commentId
     * @return Response
     */
    public function index()
    {
        return VerifiedSkill::whereNotNull('group_id')->orderBy('name')->get()->toArray();
    }
}