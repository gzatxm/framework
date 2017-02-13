<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Contracts\Console\Kernel';
    }
}
