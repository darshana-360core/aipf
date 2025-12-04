<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Log Request
        Log::channel('api')->info("API Request", [
            'method' => $request->method(),
            'url'    => $request->fullUrl(),
            'ip'     => $request->ip(),
            'headers' => $request->headers->all(),
            'body'   => $request->all(),
        ]);

        // Get response AFTER request is processed
        $response = $next($request);

        // Clone response so body can be logged
        $responseContent = $response instanceof Response
            ? $response->getContent()
            : '';

        // Log Response
        Log::channel('api')->info("API Response -> " . $request->fullUrl() , [
            'status' => $response->getStatusCode(),
            'body'   => $responseContent,
        ]);

        return $response;
    }
}
