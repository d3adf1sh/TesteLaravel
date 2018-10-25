<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class MyMiddleware2 {
    protected $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next) {
        if ($this->auth->guest()) {
            echo 'Login.';
        }

        return $next($request);
    }
}
