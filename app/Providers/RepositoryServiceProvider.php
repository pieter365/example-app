<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\ShoppingCartRepositoryInterface;
use App\Repositories\Eloquent\ShoppingCartRepository;
use App\Repositories\Contracts\ShoppingCartItemRepositoryInterface;
use App\Repositories\Eloquent\ShoppingCartItemRepository;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Eloquent\OrderItemRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the ProductRepository to the interface
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        
        // Or bind directly without an interface
        // $this->app->bind(ProductRepository::class, ProductRepository::class);

        $this->app->bind(ShoppingCartRepositoryInterface::class, ShoppingCartRepository::class);
        $this->app->bind(ShoppingCartItemRepositoryInterface::class, ShoppingCartItemRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
