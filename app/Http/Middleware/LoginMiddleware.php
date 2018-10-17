<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;
class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('buyer') === false) {
            return redirect()->route('login');
        }
        App::setLocale('zh');
        return $next($request);
    }
}
