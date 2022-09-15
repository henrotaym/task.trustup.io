<?php

namespace App\Providers;

use App\Queries\TaskQuery;
use App\Repository\TaskRepository;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegisterContract;
use Illuminate\Support\Facades\URL;
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
        /** @var AutoRegisterContract */
        $autoRegister = $this->app->make(AutoRegisterContract::class);
        $autoRegister->scanWhere(TaskQuery::class);
        $autoRegister->scanWhere(TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Forcing https requests since our app will be behind an ingress transfering http requests.
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
