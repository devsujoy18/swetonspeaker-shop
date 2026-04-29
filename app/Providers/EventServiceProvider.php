<?php

namespace App\Providers;

use App\Events\ProfileUpdated;
use App\Listeners\LogProfileUpdateListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            ProfileUpdated::class,
            LogProfileUpdateListener::class,
        );
    }
}
