<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $allow  = false;
        if(Auth::guard('api')->user())  
        {
            $user =  Auth::guard('api')->user();
            if($user->checkRoles($roles) === true) 
            {
                $allow = true;
            }             
        }
        if(!$allow) 
        {
            return response()->json(['checkRole: No permissions '], 403);   
            exit();
        }
        return $next($request);
    }
}
