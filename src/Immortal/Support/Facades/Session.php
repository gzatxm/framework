<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Session\SessionManager
 * @see \Immortal\Session\Store
 */
class Session extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}
