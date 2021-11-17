<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPermission
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
        if (isset(Auth::user()->id)){
            $user = Auth::user();
            if ($user->status == ACTIVE){
                return $next($request);
            }elseif ($user->status == INACTIVE) {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' =>__('Your account is inactive. Please change your password or contact with admin.')]);
            }
            elseif ($user->status == STATUS_BLOCKED){
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' =>__('You are blocked. Contact with admin.')]);
            } elseif ($user->status == STATUS_SUSPENDED) {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' =>__('Your Account has been suspended. please contact with admin to active again!')]);
            }else{
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' =>__('Something went wrong!')]);
            }
        }

    }
}
