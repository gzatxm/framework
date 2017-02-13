<?php

namespace Immortal\Support\Facades;

/**
 * @see \Immortal\Database\DatabaseManager
 * @see \Immortal\Database\Connection
 */
class DB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}
