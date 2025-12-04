<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomAPIThrottle
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Use user ID if logged in, otherwise fallback to IP
        $key = $request->user()
            ? 'user:' . $request->user()->id
            : 'ip:' . $request->ip();

        $maxAttempts = 60;   // 60 requests
        $decayMinutes = 1;   // in 1 minute

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($key);

            return response()->json([
                'message' => 'Too many requests. Try again in ' . $retryAfter . ' seconds.'
            ], 429);
        }

        // Record this hit
        $this->limiter->hit($key, $decayMinutes * 60);

        return $next($request);
    }
}
