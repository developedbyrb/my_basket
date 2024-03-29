<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Observers\AttributeObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\WarehouseObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Attribute::class => [AttributeObserver::class],
        Product::class => [ProductObserver::class],
        Warehouse::class => [WarehouseObserver::class],
        Order::class => [OrderObserver::class],
    ];
}
