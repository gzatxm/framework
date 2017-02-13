<?php

namespace Immortal\Pipeline;

use Immortal\Support\ServiceProvider;

class PipelineServiceProvider extends ServiceProvider
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
        $this->app->singleton(
            'Immortal\Contracts\Pipeline\Hub', 'Immortal\Pipeline\Hub'
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
            'Immortal\Contracts\Pipeline\Hub',
        ];
    }
}
