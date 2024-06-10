<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'cart/remove/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the request URI is in the except array
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request); // Allow the request to continue without CSRF verification
            }
        }

        return parent::handle($request, $next); // Perform CSRF verification for all other requests
    }
}
