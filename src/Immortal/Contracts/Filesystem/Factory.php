<?php

namespace Immortal\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string  $name
     * @return \Immortal\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
