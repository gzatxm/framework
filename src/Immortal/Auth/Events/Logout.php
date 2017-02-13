<?php

namespace Immortal\Auth\Events;

use Immortal\Queue\SerializesModels;

class Logout
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Immortal\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \Immortal\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
