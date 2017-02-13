<?php

namespace Immortal\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \Immortal\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \Immortal\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Immortal\Routing\Route  $route
     * @param  \Immortal\Http\Request  $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
