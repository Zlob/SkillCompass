<?php

use App\Helpers\Parser;
use App\Models\Job;


class ParserTest extends TestCase
{   

    private $fixture;
    public function setUp()
    {
        
        $this->fixture = \Mockery::mock('alias:App\Models\Job');
    }

    public function testJob_Is_Find()
    {   
        
        $grabberMock = \Mockery::mock('App\Helpers\Grabber');
        $grabberMock->shouldReceive('getVacancyDetails')->andReturn('something')->once();        
        
        $this->fixture->shouldReceive('getJobByVacancyId')->with(1)->andReturn(null)->atLeast(1);
        $this->fixture->shouldReceive('createJobWithSkills')->andReturn(true)->atLeast(1);


        $parser = new Parser([]);
        $parser->parseVacancy(1, $grabberMock);

    }  
    
    public function testJob_Is_Not_Find() 
    {
        $this->fixture->shouldReceive('getJobByVacancyId')->with(2)->andReturn(\Mockery::self())->atLeast(1);
        $this->fixture->shouldReceive('extendJob')->andReturn(true)->atLeast(1);
        $parser = new Parser([]);
        $parser->parseVacancy(2, null);
    }
    

}

