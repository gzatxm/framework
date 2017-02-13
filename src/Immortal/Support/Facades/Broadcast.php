<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Contracts\Broadcasting\Factory
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Contracts\Broadcasting\Factory';
    }
}
