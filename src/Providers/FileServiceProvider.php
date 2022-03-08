<?php

namespace nikitakilpa\File\Providers;

use Illuminate\Support\ServiceProvider;
use nikitakilpa\SystemJob\Jobs\RandomNumberJob;
use nikitakilpa\SystemJob\Jobs\RandomTextJob;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TEXT_RANDOM', RandomTextJob::class);
        $this->app->bind('NUMBER_RANDOM', RandomNumberJob::class);
    }

    public function boot()
    {

    }
}
