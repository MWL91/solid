<?php

namespace App\Providers;

use App\Repositories\OrderRepository;
use App\Services\Interfaces\IOrdersService;
use App\Services\OrdersService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\OrderRepository as EloquentOrderRepository;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        OrderRepository::class => EloquentOrderRepository::class,
        IOrdersService::class => OrdersService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
