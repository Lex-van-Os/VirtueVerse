<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        Log::info($roles);
        Log::info(auth()->user()->userRole->name);

        if (in_array(auth()->user()->userRole->name, $roles)) {
            return $next($request);
        }
    
        return redirect('/'); // Redirect to the home page if the role check fails
    }
}
