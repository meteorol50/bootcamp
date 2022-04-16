<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
        // 未ログイン
        if(!session()->has('name')){
            return redirect('/loglog');
        }
        return $next($request);
    }
}
