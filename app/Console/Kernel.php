<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Skill;
use App\Models\Job;
use App\Helpers\HeadHunterParser;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        
        $schedule->call(function () {
            Log::info('attaching new verified skills started');
            $skills = Skill::whereNotNull('verified_skill_id')->get();
            foreach($skills as $skill){
                $jobs = Job
                    ::whereHas('skills', function ($query) use ($skill) {
                        $query->where('skill_id', $skill->id);
                    })
                        ->whereHas('verifiedSkills', function ($query) use ($skill) {
                            $query->where('verified_skill_id', $skill->verified_skill_id);
                        }, '<', 1)
                        ->get();
                foreach($jobs as $job){
                    $job->verifiedSkills()->attach($skill->verified_skill_id); 
                }            
            }
        })->daily();

        $schedule->call(function () {
            Log::info('HH parsing started');
            $hhParser = new \App\Helpers\HeadHunterParser();
            $hhParser->parse();          
        })->daily();
    }
}
