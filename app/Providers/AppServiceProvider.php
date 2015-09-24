<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\HeadHunterGrabber;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Helpers\HeadHunterGrabber', function ($app) {
            $client = new \Guzzle\Service\Client('https://api.hh.ru');
            $client->setUserAgent( 'SkillPricer/1.0 (vamakin@gmail.com)');
            $grabber = new HeadHunterGrabber($client);
            return $grabber;
        });
    }
}
