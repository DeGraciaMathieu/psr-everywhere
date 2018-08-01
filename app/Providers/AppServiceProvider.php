<?php

namespace App\Providers;

use App\Services\GitService;
use Illuminate\Support\ServiceProvider;
use App\Managers\GithubApi\GithubApiManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // todo : remove this
        // thx windows seven
        putenv('PATH='. getenv('PATH') .';C:\laragon3\bin\git\bin');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GithubApiManager::class, function ($app) {
            return (new GithubApiManager($app))->driver();
        });

        $this->app->bind(GitService::class, function ($app) {
            return new GitService($app['config']['gitrepository']);
        });        
    }
}
