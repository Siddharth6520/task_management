<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DB\DBConnection;
use Doctrine\ODM\MongoDB\DocumentManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DocumentManager::class, function ($app) {

            return (new DBConnection())->dbConnection();
        });
    }
    // testing
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
