<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\ProductInterface',
            'App\Repositories\ProductRepository'
        );

        $this->app->bind(
            'App\Interfaces\PriceInterface',
            'App\Repositories\PriceRepository'
        );

        $this->app->bind(
            'App\Interfaces\TransactionInterface',
            'App\Repositories\TransactionRepository'
        );
    }
}