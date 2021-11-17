<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Localization
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
        $lang = App::getLocale();
        if (isset(Auth::user()->language)) {
            App::setLocale(Auth::user()->language);
        }else{
            App::setLocale($lang);
        }
        return $next($request);
    }
}
