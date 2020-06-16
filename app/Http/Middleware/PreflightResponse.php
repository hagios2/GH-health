<?php

namespace App\Http\Middleware;

use Closure;

class PreflightResponse
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
        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE', 'PATCH',
            'Access-Control-Allow-Headers' => 'X-PINGOTHER', 'Content-Type, X-Auth-Token, Origin, Authorization'
       
        ]; 

        if ($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return response('', 204, $headers);
         //   ->header('Access-Control-Allow-Origin', implode(',', config('cors.allow_origins')))
           // ->header('Access-Control-Allow-Methods', implode(',', config('cors.allow_methods')))
            //->header('Access-Control-Allow-Headers', implode(',', config('cors.allow_headers')))
           // ->header('Access-Control-Max-Age', implode(',', config('cors.max_age')));
        }
        
        return $next($request);
    }
}
