<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Auth\AuthManager
 * @see \Immortal\Contracts\Auth\Factory
 * @see \Immortal\Contracts\Auth\Guard
 * @see \Immortal\Contracts\Auth\StatefulGuard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @return void
     */
    public static function routes()
    {
        static::$app->make('router')->auth();
    }
}
