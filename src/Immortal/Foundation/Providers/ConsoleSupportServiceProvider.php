<?php

namespace Immortal\Foundation\Providers;

use Immortal\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Immortal\Foundation\Providers\ArtisanServiceProvider',
        'Immortal\Console\ScheduleServiceProvider',
        'Immortal\Database\MigrationServiceProvider',
        'Immortal\Database\SeedServiceProvider',
        'Immortal\Foundation\Providers\ComposerServiceProvider',
        'Immortal\Queue\ConsoleServiceProvider',
    ];
}
