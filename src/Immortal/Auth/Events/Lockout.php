<?php

namespace Immortal\Auth\Events;

use Immortal\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \Immortal\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Immortal\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
