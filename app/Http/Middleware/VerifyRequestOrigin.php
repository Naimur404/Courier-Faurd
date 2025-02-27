<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyRequestOrigin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        $token = config('app.token'); // Get the token from config

        if (!Hash::check($token, '$2y$10$uOsq1UWVr/t1oX7jxW0fseLRJI6mWbR6VQfCP5r0NJVVqgXkpi09C')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return $next($request);
    }
}