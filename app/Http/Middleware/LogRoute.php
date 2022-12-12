<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRoute
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
        $response = $next($request);
        $log = [
            'URI'                =>       $request->getUri(),
            'METHOD'             =>       $request->getMethod(),
            'REQUEST_BODY'       =>       $request->all(),
            'RESPONSE'           =>       $request->getContent()
        ];

        Log::channel('request')->info(json_encode($log));
        return $next($request);
    }
}