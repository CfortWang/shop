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
        // dd($request->session()->get('buyer'));
        // dd(Session::all());
        if ($request->session()->has('buyer') === false) {
            return redirect()->route('login');
        }
        // dd($request->session()->get('buyer'));
        App::setLocale('zh');
        return $next($request);
    }
}
