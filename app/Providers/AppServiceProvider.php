<?php

namespace App\Providers;

use App\Repositories\NewsEloquentORM;
use App\Repositories\NewsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //bind to inject dependancy
        $this->app->bind(
            NewsRepositoryInterface::class, 
            NewsEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
