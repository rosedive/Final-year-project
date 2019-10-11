<?php

namespace App\Providers;

use App\Events\User\Banned;
use App\Events\User\LoggedIn;
use App\Events\User\Registered;
use App\Listeners\Users\InvalidateSessionsAndTokens;
use App\Listeners\Login\UpdateLastLoginTimestamp;
use App\Listeners\PermissionEventsSubscriber;
use App\Listeners\Registration\SendConfirmationEmail;
use App\Listeners\Registration\SendSignUpNotification;
use App\Listeners\RoleEventsSubscriber;
use App\Listeners\UserEventsSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendConfirmationEmail::class,
            SendSignUpNotification::class,
        ],
        LoggedIn::class => [
            UpdateLastLoginTimestamp::class
        ],
        Banned::class => [
            InvalidateSessionsAndTokens::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventsSubscriber::class,
        RoleEventsSubscriber::class,
        PermissionEventsSubscriber::class
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
