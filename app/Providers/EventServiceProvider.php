<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
    Login::class => [LogSuccessfulLogin::class],
    Logout::class => [LogSuccessfulLogout::class],
    Failed::class => [LogFailedLogin::class], 
    ];

    public function boot(): void
    {
        //
    }
}