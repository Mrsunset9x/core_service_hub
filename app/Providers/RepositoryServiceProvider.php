<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(\App\Repositories\Interfaces\SkillVerbRepository::class, \App\Repositories\SkillVerbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\LicenseRepository::class, \App\Repositories\LicenseRepositoryEloquent::class);
        //:end-bindings:
    }
}
