<?php

namespace App\Http\Middleware;

use Closure;

class MyMiddleware3 {
    public function handle($request, Closure $next) {
        $response = $next($request);
        $response->header('my-header', 'present');
        echo 'Header.';
        return $response;
    }
}
