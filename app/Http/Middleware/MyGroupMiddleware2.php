<?php

namespace App\Http\Middleware;

use Closure;

class MyGroupMiddleware2 {
    public function handle($request, Closure $next) {
        echo '2.';
        return $next($request);
    }
}
