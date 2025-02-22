<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Entities\AgeLoad\AgeLoadInterface;
//use App\Domain\Entities\AgeLoad\AgeLoadCached;
use App\Domain\Entities\AgeLoad\AgeLoadHardcoded;

class AgeLoadProvider extends ServiceProvider
{

    public function register(): void
    {
        /*$ageload_source = config('ageload_source');

        if ($ageload_source === 'cache') {
            $this->app->bind(AgeLoadInterface::class, function ($app) {
                return new AgeLoadCached($app->make(Cache::class));
            });
        } 

        $this->app->singleton(Cache::class, function ($app) {
            return new Cache();
        });*/

        $this->app->bind(AgeLoadInterface::class, function ($app) {
            return new AgeLoadHardcoded();
        });
    }
}
