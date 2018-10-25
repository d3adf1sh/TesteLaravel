<?php

namespace App\Http\Middleware;

use Closure;

class MyMiddleware6 {
    public function handle($request, Closure $next, $first, $second) {
        $response = $next($request);
        echo $first.'.'.$second;
        return $response;
    }
}
