<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AnyJsonTester\AnyJsonTesterLaravel;
use AnyJsonTester\Types\AnyArray;
use AnyJsonTester\Types\AnyObject;
use AnyJsonTester\Types\AnyInteger;
use AnyJsonTester\Types\AnyString;
use AnyJsonTester\Types\AnyDateTime;



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
                            "id" => new AnyInteger(['min' => 1]),
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
    
    public function testApiPopularChartInfo()
    {
        $this->post('api/popular-chart-info', ['id' => 100, 'areaId' => 2])
            ->seeJsonLike(
            new AnyArray(
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
            )
        );
    }
    
    public function testApiRelatedChartInfo()
    {
        $this->post('api/related-chart-info', ['id' => 100, 'areaId' => 2])
            ->seeJsonLike(
            new AnyArray(
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
            )
        );
    }

    
    
    
}