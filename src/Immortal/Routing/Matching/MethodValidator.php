<?php

namespace Immortal\Routing\Matching;

use Immortal\Http\Request;
use Immortal\Routing\Route;

class MethodValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Immortal\Routing\Route  $route
     * @param  \Immortal\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
