<?php

namespace App\Http\Middleware;

use Closure;

class MyGroupMiddleware1 {
    public function handle($request, Closure $next) {
        echo '1.';
        return $next($request);
    }
}
