<?php

namespace App\Providers;

use App\Repositories\RestaurantRepository;
use App\Repositories\RestaurantRepositoryInterface;
use Illuminate\Support\ServiceProvider;
include __DIR__ . '/../Helpers/helpers-repositories.php';

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RestaurantRepositoryInterface::class, RestaurantRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
