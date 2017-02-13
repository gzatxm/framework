<?php

namespace Immortal\Bus;

use Immortal\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Immortal\Bus\Dispatcher', function ($app) {
            return new Dispatcher($app, function ($connection = null) use ($app) {
                return $app['Immortal\Contracts\Queue\Factory']->connection($connection);
            });
        });

        $this->app->alias(
            'Immortal\Bus\Dispatcher', 'Immortal\Contracts\Bus\Dispatcher'
        );

        $this->app->alias(
            'Immortal\Bus\Dispatcher', 'Immortal\Contracts\Bus\QueueingDispatcher'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Immortal\Bus\Dispatcher',
            'Immortal\Contracts\Bus\Dispatcher',
            'Immortal\Contracts\Bus\QueueingDispatcher',
        ];
    }
}
