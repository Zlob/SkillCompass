<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Config;
use JsonServer\JsonServer;
use App\Helpers\HeadHunterParser;

class ParserController extends Controller
{
    public function parse()
    {
        $hhParser = new \App\Helpers\HeadHunterParser();
        $hhParser->parse();
    }    
    
    public function reattach()
    {
        $hhParser = new \App\Helpers\HeadHunterParser();
        $hhParser->attachNewVerifiedSkills();
    } 
    
}