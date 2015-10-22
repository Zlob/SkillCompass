<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AnyJsonTester\AnyJsonTesterLaravel;
use AnyJsonTester\Types\AnyArray;
use AnyJsonTester\Types\AnyObject;
use AnyJsonTester\Types\AnyInteger;
use AnyJsonTester\Types\AnyFloat;
use AnyJsonTester\Types\AnyString;
use AnyJsonTester\Types\AnyDateTime;
use AnyJsonTester\Types\AnyBoolean;



class ApiTest extends TestCase
{
    use WithoutMiddleware;
    use AnyJsonTesterLaravel;

    public function testApiGroup()
    {
        $this->get('/api/group')
            ->seeJsonLike(
            new AnyArray(
                new AnyObject( 
                    [
                        'hasFields' => [
                            "id" => new AnyInteger(['min' => 0]),
                            "name" => new AnyString(['min' => 1, 'max' => 50]),
                            "position"=> new AnyInteger(['min' => 0])
                        ],
                        'strictMode' => true 
                    ]
                )             
            )
        );        
    }

    public function testApiSkill()
    {
        $this->get('api/skill')
            ->seeJsonLike(
            new AnyArray(
                new AnyObject(
                    [
                        'hasFields' => [
                            "id" => new AnyInteger(['min' => 1]),
                            "name" => new AnyString(['min' => 1, 'max' => 30]),
                            'created_at' => new AnyDateTime(['format' => 'Y-m-d H:i:s']),
                            'updated_at' => new AnyDateTime(['format' => 'Y-m-d H:i:s']),
                            "group_id" => new AnyInteger(['min' => 1])
                        ],
                        'strictMode' => true
                    ]
                )
            )
        );
    }
    
    public function testApiStatisticInfo()
    {
        $relatedInfoObject = new AnyArray(
            new AnyObject(
                [
                    'hasFields' => [
                        "total_count" => new AnyInteger(['min' => 0]),
                        "name" => new AnyString([
                            'min' => '1',
                            'max' => '20'
                        ]),
                    ],
                    'strictMode' => true
                ]
            ),
            [
                'min' => 1,
                'max' => 20
            ]                
        );
        
        $popularInfoObject = new AnyArray(
            new AnyObject(
                [
                    'hasFields' => [
                        "total_count" => new AnyInteger(['min' => 0]),
                        "name" => new AnyString([
                            'enum' => [
                                'January',
                                'February',
                                'March',
                                'April',
                                'May',
                                'June',
                                'July',
                                'August',
                                'September',
                                'October',
                                'November',
                                'December'
                            ]
                        ]),
                    ],
                    'strictMode' => true
                ]
            )
        );
        
        $statisticInfoObject = new AnyObject(
            [
                'hasFields' => [
                    'popular_chart_info' => $popularInfoObject,
                    'related_chart_info' => $relatedInfoObject,                    
                ],
                'strictMode' => true
            ]
        );
        
        $statisticInfoArray = new AnyArray($statisticInfoObject);        
        
        $this->post('api/statistic-info', ['skills_ids' => [70, 100], 'areaId' => 2])
            ->seeJsonLike($statisticInfoArray);
    }
    
    
    public function testApiJobsBySkills()
    {
        $aggregation = new AnyObject(
            [
                'hasFields' => [
                    'name' => new AnyString(['min' => 0]),
                    'min' => new AnyFloat(['min' => 0]),
                    'max' => new AnyFloat(['min' => 0]),
                    'mid' => new AnyFloat(['min' => 0]),
                    'total_count' => new AnyInteger(['min' => 0]),
                    'actual_count' => new AnyInteger(['min' => 0]),
                    'additional_skills_count' => new AnyInteger(['min' => 0]),
                    'additional_skills' => new AnyArray(new AnyObject(['hasFields' => ['name' => new AnyString()]]))
                ],
                'strictMode' => true
            ]
        );
        $actual_job = new AnyObject(
            [
                'hasFields' => [
                    'id' => new AnyInteger(['min' => 0]),
                    'cost' => new AnyFloat(['min' => 0]),
                    'url' => new AnyString(['min' => 0]),
                    'actual' => new AnyBoolean(),
                    'name' =>  new AnyString(['min' => 0]),
                    'additional_skills_count' => new AnyInteger(['min' => 0]),
                    'additional_skills' => new AnyArray(new AnyObject(['hasFields' => ['name' => new AnyString()]])),
                    'have_skills' => new AnyArray(new AnyObject(['hasFields' => ['name' => new AnyString()]]))
                ],
                'strictMode' => true
            ]

        );
        
        $this->post('api/jobs-by-skills', ['skillIds' => [70], 'areaId' => 2])
            ->seeJsonLike(
            new AnyArray(
                new AnyObject(
                    [
                        'hasFields' => [
                            "aggregation" => $aggregation,
                            "actual_jobs" => new AnyArray($actual_job)
                        ]
                    ]
                )               
            )
        );
    }

    
    
    
}