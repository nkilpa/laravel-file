<?php

namespace nikitakilpa\File\Providers;

use Illuminate\Support\ServiceProvider;
use nikitakilpa\File\Jobs\PublishMessageJob;
use nikitakilpa\File\Jobs\RandomNumberJob;
use nikitakilpa\File\Jobs\RandomTextJob;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TEXT_RANDOM', RandomTextJob::class);
        $this->app->bind('NUMBER_RANDOM', RandomNumberJob::class);
        $this->app->bind('PUBLISH_MESSAGE', PublishMessageJob::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
    }
}
