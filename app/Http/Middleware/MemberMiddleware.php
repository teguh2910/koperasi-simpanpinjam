<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isMember()) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}