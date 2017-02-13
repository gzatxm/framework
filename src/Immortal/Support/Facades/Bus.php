<?php

namespace Immortal\Support\Facades;

use Immortal\Support\Testing\Fakes\BusFake;

/**
 * @see \Immortal\Contracts\Bus\Dispatcher
 */
class Bus extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new BusFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Contracts\Bus\Dispatcher';
    }
}
