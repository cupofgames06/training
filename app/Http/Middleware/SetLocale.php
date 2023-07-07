<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if(in_array($request->segment(1), config('app.supported_locales'))){
            app()->setLocale($request->segment(1));
        }


        URL::defaults(['locale' => app()->getLocale()]);

        return $next($request);
    }
}
