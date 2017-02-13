<?php

namespace Immortal\Support\Facades;

use Immortal\Support\Testing\Fakes\NotificationFake;

/**
 * @see \Immortal\Notifications\ChannelManager
 */
class Notification extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new NotificationFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Notifications\ChannelManager';
    }
}
