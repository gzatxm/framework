<?php

namespace Immortal\Support\Facades;

use Immortal\Support\Testing\Fakes\QueueFake;

/**
 * @see \Immortal\Queue\QueueManager
 * @see \Immortal\Queue\Queue
 */
class Queue extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new QueueFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}
