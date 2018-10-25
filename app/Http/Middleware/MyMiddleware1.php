<?php

namespace App\Http\Middleware;

use Closure;

class MyMiddleware1 {
    public function handle($request, Closure $next) {
        if ($request->has('finalizar')) {
            echo 'Finalizar.';
        }

        return $next($request);
    }
}
