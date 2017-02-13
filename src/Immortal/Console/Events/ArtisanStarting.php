<?php

namespace Immortal\Console\Events;

class ArtisanStarting
{
    /**
     * The Artisan application instance.
     *
     * @var \Immortal\Console\Application
     */
    public $artisan;

    /**
     * Create a new event instance.
     *
     * @param  \Immortal\Console\Application  $artisan
     * @return void
     */
    public function __construct($artisan)
    {
        $this->artisan = $artisan;
    }
}
