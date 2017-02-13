<?php

namespace Immortal\Session\Middleware;

use Closure;
use Immortal\Auth\AuthenticationException;
use Immortal\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \Immortal\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Immortal\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Immortal\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user() || ! $request->session()) {
            return $next($request);
        }

        if (! $request->session()->has('password_hash') && $this->auth->viaRemember()) {
            $this->logout($request);
        }

        if (! $request->session()->has('password_hash')) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get('password_hash') !== $request->user()->password) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            $this->storePasswordHashInSession($request);
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \Immortal\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        $request->session()->put([
            'password_hash' => $request->user()->password,
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Immortal\Http\Request  $request
     * @return void
     *
     * @throws \Immortal\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->auth->logout();

        $request->session()->flush();

        throw new AuthenticationException;
    }
}
