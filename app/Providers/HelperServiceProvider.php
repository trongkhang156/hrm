<?php

namespace App\Providers;
use App\Models\WorkType;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (glob(app_path() . '/Helpers/*.php') as $helpersfilename)
        {
            require_once($helpersfilename);
        }
    }
  
}
