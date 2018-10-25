<?php

namespace App\Http\Middleware;

use Closure;

class MyMiddleware4 {
    public function handle($request, Closure $next) {
        $response = $next($request);
        echo 'XXX.';
        return $response;
    }
}
