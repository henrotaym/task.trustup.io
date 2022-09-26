<?php

namespace App\Providers;

use App\Queries\TaskQuery;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Api\Auth\Endpoints\UserEndpoint;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\Relation;
use Henrotaym\LaravelContainerAutoRegister\Services\AutoRegister\Contracts\AutoRegisterContract;

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
        $autoRegister->scanWhere(UserEndpoint::class);

        Relation::enforceMorphMap([
            'task' => Task::class
        ]);
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
