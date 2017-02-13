<?php

namespace Immortal\Auth\Middleware;

use Closure;
use Immortal\Contracts\Auth\Access\Gate;
use Immortal\Contracts\Auth\Factory as Auth;

class Authorize
{
    /**
     * The authentication factory instance.
     *
     * @var \Immortal\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * The gate instance.
     *
     * @var \Immortal\Contracts\Auth\Access\Gate
     */
    protected $gate;

    /**
     * Create a new middleware instance.
     *
     * @param  \Immortal\Contracts\Auth\Factory  $auth
     * @param  \Immortal\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function __construct(Auth $auth, Gate $gate)
    {
        $this->auth = $auth;
        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Immortal\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $ability
     * @param  array|null  $models
     * @return mixed
     *
     * @throws \Immortal\Auth\AuthenticationException
     * @throws \Immortal\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $this->auth->authenticate();

        $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        return $next($request);
    }

    /**
     * Get the arguments parameter for the gate.
     *
     * @param  \Immortal\Http\Request  $request
     * @param  array|null  $models
     * @return array|string|\Immortal\Database\Eloquent\Model
     */
    protected function getGateArguments($request, $models)
    {
        if (is_null($models)) {
            return [];
        }

        return collect($models)->map(function ($model) use ($request) {
            return $this->getModel($request, $model);
        })->all();
    }

    /**
     * Get the model to authorize.
     *
     * @param  \Immortal\Http\Request  $request
     * @param  string  $model
     * @return string|\Immortal\Database\Eloquent\Model
     */
    protected function getModel($request, $model)
    {
        return $this->isClassName($model) ? $model : $request->route($model);
    }

    /**
     * Checks if the given string looks like a fully qualified class name.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isClassName($value)
    {
        return strpos($value, '\\') !== false;
    }
}
