<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;

class AdminAuthCheckMiddleware
{
    use Helper;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()){
            return $next($request);
        }

        return $this->notPermitted();
    }
}
