<?php

namespace Immortal\Broadcasting;

use Immortal\Http\Request;
use Immortal\Routing\Controller;
use Immortal\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Immortal\Http\Request  $request
     * @return \Immortal\Http\Response
     */
    public function authenticate(Request $request)
    {
        return Broadcast::auth($request);
    }
}
