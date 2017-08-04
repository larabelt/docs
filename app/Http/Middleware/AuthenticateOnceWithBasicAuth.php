<?php

namespace App\Http\Middleware;

use Auth, Closure, Cookie;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateOnceWithBasicAuth
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->skip() || $this->attempt()) {
            return $next($request);
        }

        return $this->prompt();
    }

    /**
     * Check to see if authentication request should be skipped
     *
     * @return bool
     */
    public function skip()
    {
        if (!config('session.basic.username') || !config('session.basic.password')) {
            return true;
        }

        if (Auth::check()) {
            return true;
        }

        if (Cookie::get('basic') == $this->answer()) {
            return true;
        }

        return false;
    }

    /**
     * Attempt to authenticate request
     *
     * @return bool
     */
    public function attempt()
    {
        if ($this->credentials() == $this->answer()) {
            $this->authenticate();
            return true;
        }

        return false;
    }

    /**
     * Get expected credentials
     *
     * @return array
     */
    public function answer()
    {
        return [config('session.basic.username'), config('session.basic.password')];
    }

    /**
     * Get posted credentials
     *
     * @return array
     */
    public function credentials()
    {
        $request = $this->auth->getRequest();

        return [$request->getUser(), $request->getPassword()];
    }

    /**
     * Set cookie to remember authentication
     */
    public function authenticate()
    {
        Cookie::queue('basic', $this->credentials());
    }

    /**
     * Return Basic user/pass prompt
     *
     * @return Response
     */
    public function prompt()
    {
        return new Response('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
    }

}
