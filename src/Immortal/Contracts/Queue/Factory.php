<?php

namespace Immortal\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string  $name
     * @return \Immortal\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
