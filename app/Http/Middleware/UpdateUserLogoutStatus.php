<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateUserLogoutStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Handle the request
        $response = $next($request);

        if(Auth::check() || backpack_auth()->check()){
            backpack_user()->update(['is_online' => true,'last_login' => now()]);

           // backpack_user()->update(['is_online' => false]);

       }

        

        return $response;
    }
 
}
