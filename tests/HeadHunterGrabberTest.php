<?php

use App\Helpers\HeadHunterGrabber;
use App\Helpers\ApiRequest;


class HeadHunterGrabberTest extends TestCase
{   
    private $fixture;
    public function setUp()
    {
        $stub = $this
            ->getMockBuilder('App\Helpers\ApiRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $stub->method('getRequestData')
            ->willReturn(['items' => [['id' => 1],['id' => 2],['id' => 3]]]);


        $grabber = new HeadHunterGrabber($stub);
        $this->fixture = $grabber;
    }

    public function testGetCost_Min_10_Max_20_Eqial_15()
    {

        $cost = $this->fixture->getCost(10, 20, 'RUR');
        $this->assertEquals(15, $cost, 'vacancy cost equals 15');
    }  
    
    public function testGetCost_Min_0_Max_20_Eqial_20()
    {

        $cost = $this->fixture->getCost(0, 20, 'RUR');
        $this->assertEquals(20, $cost, 'vacancy cost equals 20');
    }  
    
    public function testGetCost_Min_20_Max_0_Eqial_20()
    {

        $cost = $this->fixture->getCost(20, 0, 'RUR');
        $this->assertEquals(20, $cost, 'vacancy cost equals 20');
    }  
    
    public function testGetCost_USD_Conversion()
    {
        $cost = $this->fixture->getCost(20, 200, 'USD');
        $this->assertEquals(6600 , $cost, 'vacancy cost equals 15');
    }  
    
    public function testGetVacancySkillsFromText_One_Word()
    {
        $skills = $this->fixture->GetVacancySkillsFromText('Разработка на PHP сайтов');
        $this->assertEquals(['PHP'] , $skills, 'GetVacancySkillsFromText parse "PHP"');
    }  
    
    public function testGetVacancySkillsFromText_One_Word_With_Number()
    {
        $skills = $this->fixture->GetVacancySkillsFromText('Разработка на PHP 7 сайтов');
        $this->assertEquals(['PHP 7'] , $skills, 'GetVacancySkillsFromText parse "PHP 7"');
    }  
    
    public function testGetVacancySkillsFromText_Two_Word_With_Number()
    {
        $skills = $this->fixture->GetVacancySkillsFromText('Разработка на PHP 7 и HTML 5 сайтов');
        $this->assertEquals(['PHP 7', 'HTML 5'] , $skills, 'GetVacancySkillsFromText parse "PHP 7" & "HTML 5"');
    }  
    
    public function testGetVacancySkillsFromText_Two_Word_Non_Separated()
    {
        $skills = $this->fixture->GetVacancySkillsFromText('Разработка на PHP 7 HTML сайтов');
        $this->assertEquals(['PHP 7', 'HTML'] , $skills, 'GetVacancySkillsFromText parse "PHP 7" & "HTML"');
    }  
    
    public function testGetVacancySkillsFromText_More_Then_20_Words()
    {
        $skills = $this->fixture->GetVacancySkillsFromText("Lusitania had the misfortune to fall victim to torpedo attack relatively early in the First World War, before tactics for evading submarines were properly implemented or understood. The contemporary investigations in both the UK and the United States into the precise causes of the ship's loss were obstructed by the needs of wartime secrecy and a propaganda campaign to ensure all blame fell upon Germany. Argument over whether the ship was a legitimate military target raged back and forth throughout the war as both sides made misleading claims about the ship. At the time she was sunk, she was carrying a large quantity of rifle cartridges and non-explosive shell casings, as well as civilian passengers. Several attempts have been made over the years since the sinking to dive to the wreck seeking information about precisely how the ship sank, and argument continues to the present day.");
        $this->assertEquals([] , $skills, 'GetVacancySkillsFromText parse vacancy in english and return []');
    }  
    

}

