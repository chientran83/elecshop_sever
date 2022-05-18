<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class allowedDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $allowedOrigins = ['abc', 'http://localhost:8080/'];
        if($request->server('HTTP_REFERER')){
            if (in_array($request->server('HTTP_REFERER'),$allowedOrigins)) {
                $headers = [
                    'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Max-Age'           => '86400',
                    'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
                ];
                
                if ($request->isMethod('OPTIONS')) {
                    return response()->json('{"method":"OPTIONS"}', 200, $headers);
                }
                
                $response = $next($request);
                foreach($headers as $key => $value) {
                    $response->headers->set($key, $value);
                }
                return $response;
            }
        }


    }
}
