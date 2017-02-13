<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Cache\CacheManager
 * @see \Immortal\Cache\Repository
 */
class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cache';
    }
}
