<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Contracts\Routing\ResponseFactory
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Immortal\Contracts\Routing\ResponseFactory';
    }
}
