<?php

namespace EasifyAllegro\Http\Middleware;

use Closure;
use Cookie;

class MagicCurtain
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
      // if(Cookie::get('mainpermitted') != '1'){
      //   return response('Oczekuj czegos niesamowitego', 503);
      // }
      // else{
      //   return $next($request);
      // }

      return $next($request);
    }
}
