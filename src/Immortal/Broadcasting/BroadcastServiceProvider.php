<?php

namespace Immortal\Broadcasting;

use Immortal\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
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
        $this->app->singleton('Immortal\Broadcasting\BroadcastManager', function ($app) {
            return new BroadcastManager($app);
        });

        $this->app->singleton('Immortal\Contracts\Broadcasting\Broadcaster', function ($app) {
            return $app->make('Immortal\Broadcasting\BroadcastManager')->connection();
        });

        $this->app->alias(
            'Immortal\Broadcasting\BroadcastManager', 'Immortal\Contracts\Broadcasting\Factory'
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
            'Immortal\Broadcasting\BroadcastManager',
            'Immortal\Contracts\Broadcasting\Factory',
            'Immortal\Contracts\Broadcasting\Broadcaster',
        ];
    }
}
