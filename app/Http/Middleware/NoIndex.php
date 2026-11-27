<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tells search engines not to index or follow a page: an X-Robots-Tag header,
 * plus a robots meta tag the root view renders from the shared `robotsDirective`.
 * Applied to Internal Tools, which are reachable by URL but not public.
 */
class NoIndex
{
    public const DIRECTIVE = 'noindex, nofollow';

    public function handle(Request $request, Closure $next): Response
    {
        View::share('robotsDirective', self::DIRECTIVE);

        $response = $next($request);
        $response->headers->set('X-Robots-Tag', self::DIRECTIVE);

        return $response;
    }
}
