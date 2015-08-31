<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;

class GroupController extends Controller
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
        return Group::all()->toArray();
    }
}