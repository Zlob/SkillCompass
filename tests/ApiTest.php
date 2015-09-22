<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use AnyJsonTester\AnyJsonTesterLaravel;
use AnyJsonTester\Types\AnyArray;
use AnyJsonTester\Types\AnyObject;


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
                        "id" => "1",
                        "name" => "Языки программирования",
                        "created_at" => "-0001-11-30 00:00:00",
                        "updated_at" => "-0001-11-30 00:00:00",
                        "position"=> "10"
                    ]
                )
            )
        );        
    }

//     public function testApiSkill()
//     {
//         $this->get('api/skill')
//             ->seeJson([
//                 "id" => 1,
//                 "name" => "Adobe Illustrator",
//                 "created_at" => "-0001-11-30 00:00:00",
//                 "updated_at" => "-0001-11-30 00:00:00",
//                 "group_id" => "2"
//             ]);
//     }

    
    
    
}