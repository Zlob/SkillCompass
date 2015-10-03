<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;

class updateJobNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateJobNames:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    
    private $job;
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        parent::__construct();
        $this->job = $job;
        $this->client = new \Guzzle\Service\Client('https://api.hh.ru');
        $this->client->setUserAgent( 'SkillPricer/1.0 (vamakin@gmail.com)');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs = $this->job->all();
        foreach($jobs as $jobModel){
            $id = $jobModel->vacancy_id;
            try{
                $response = $this->client->get("https://api.hh.ru/vacancies/$id", [])->send();
                if($response->getStatusCode() == 200){
                    $responseArray = json_decode($response->getBody(), true);
                    $jobModel->name = $responseArray['name'];
                    $jobModel->save();
                }
            }
            catch(\Guzzle\Http\Exception\ClientErrorResponseException $e){
                echo $id;
            }

        }

    }
}
