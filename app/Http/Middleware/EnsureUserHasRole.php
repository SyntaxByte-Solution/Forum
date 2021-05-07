<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\AccessDeniedException;
use App\Models\Role;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $slug)
    {
        if (!$request->user()->has_role($slug)) {
            throw new AccessDeniedException("Access denied.");
        }

        return $next($request);
    }
}
