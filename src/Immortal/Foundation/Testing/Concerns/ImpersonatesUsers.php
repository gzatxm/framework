<?php

namespace Immortal\Foundation\Testing\Concerns;

use Immortal\Contracts\Auth\Authenticatable as UserContract;

trait ImpersonatesUsers
{
    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Immortal\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $driver
     * @return $this
     */
    public function actingAs(UserContract $user, $driver = null)
    {
        return $this->be($user, $driver);
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Immortal\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $driver
     * @return $this
     */
    public function be(UserContract $user, $driver = null)
    {
        $this->app['auth']->guard($driver)->setUser($user);

        return $this;
    }
}
