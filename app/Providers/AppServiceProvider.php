<?php

namespace App\Providers;

use App\Repositories\News\{NewsEloquentORM, NewsRepositoryInterface};
use App\Repositories\User\{UserEloquentORM, UserRepositoryInterface};
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
        $this->app->bind(
            UserRepositoryInterface::class, 
            UserEloquentORM::class
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
