<?php

namespace Immortal\Foundation\Bootstrap;

use Immortal\Foundation\AliasLoader;
use Immortal\Support\Facades\Facade;
use Immortal\Contracts\Foundation\Application;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Immortal\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance($app->make('config')->get('app.aliases', []))->register();
    }
}
