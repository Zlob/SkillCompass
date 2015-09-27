<?php

use App\Helpers\HeadHunterGrabber;
use App\Helpers\ApiRequest;
use App\Helpers\Grabber;


class AbstractGrabberTest extends TestCase
{    

    public function testIterable()
    {

        $stub = $this
            ->getMockBuilder('App\Helpers\ApiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $abstractGrabber = new GrabberTest($stub);
        $itemsCount = 0;
        foreach($abstractGrabber as $key => $value){
            $itemsCount ++;
        }
        $this->assertEquals(5, $itemsCount, 'iterate thru 5 objects');

    }  
    
}

//dump realization of abstractGrabber
class GrabberTest extends Grabber
{
    protected function getVacancies()
    {
        return [1,2,3,4,5];
    }    

    public function getVacancyDetails($jobId)
    {
        return $jobId;
    }
}

