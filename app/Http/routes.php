<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::resource('api/group', 'GroupController');
Route::resource('api/skill', 'VerifiedSkillController');
Route::post('api/popular-chart-info', 'ChartController@getPopularChartInfo');
Route::post('api/related-chart-info', 'ChartController@getrelatedChartInfo');

Route::get('/parse', "ParserController@parse");


// Route::any('fakeapi/{all}', "JsonServerController@handleRequest")->where('all', '.*');
