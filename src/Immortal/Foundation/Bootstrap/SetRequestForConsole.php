<?php

namespace Immortal\Foundation\Bootstrap;

use Immortal\Http\Request;
use Immortal\Contracts\Foundation\Application;

class SetRequestForConsole
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Immortal\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $url = $app->make('config')->get('app.url', 'http://localhost');

        $app->instance('request', Request::create($url, 'GET', [], [], [], $_SERVER));
    }
}
