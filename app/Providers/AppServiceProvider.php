<?php

namespace App\Providers;

use App\CRUDBooster\Helpers\BaseCRUDBooster;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Override auth api crudbooster
        // $loader = AliasLoader::getInstance();  
        // $loader->alias(CRUDBooster::class, BaseCRUDBooster::class);

        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
