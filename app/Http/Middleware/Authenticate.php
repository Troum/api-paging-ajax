<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory;
class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response('Вы не авторизованы', 401);
        }

        return $next($request);
    }
}
