<?php

namespace Immortal\Routing\Matching;

use Immortal\Http\Request;
use Immortal\Routing\Route;

class HostValidator implements ValidatorInterface
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
        if (is_null($route->getCompiled()->getHostRegex())) {
            return true;
        }

        return preg_match($route->getCompiled()->getHostRegex(), $request->getHost());
    }
}
