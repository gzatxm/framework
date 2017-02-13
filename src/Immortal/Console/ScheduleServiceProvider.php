<?php

namespace Immortal\Console;

use Immortal\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
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
        $this->commands('Immortal\Console\Scheduling\ScheduleRunCommand');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Immortal\Console\Scheduling\ScheduleRunCommand',
        ];
    }
}
