<?php

namespace EasifyAllegro\Http\Middleware;

use Closure;

class SetTimeZone
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
      date_default_timezone_set("Europe/Warsaw");
      return $next($request);
    }
}
