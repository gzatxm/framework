<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Contracts\Auth\Access\Gate
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Contracts\Auth\Access\Gate';
    }
}
