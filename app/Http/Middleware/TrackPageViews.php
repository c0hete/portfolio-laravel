<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\HubEventReporter;

class TrackPageViews
{
    public function __construct(
        private HubEventReporter $hub
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track if enabled
        if (!config('services.hub.track_pageviews')) {
            return $response;
        }

        // Only track successful GET requests to HTML pages
        if (
            $request->isMethod('GET') &&
            $response->isSuccessful() &&
            !$this->shouldIgnore($request)
        ) {
            $this->hub->reportPageView(
                path: $request->path(),
                userAgent: $request->userAgent(),
                referer: $request->header('referer')
            );
        }

        return $response;
    }

    /**
     * Determine if the request should be ignored
     */
    private function shouldIgnore(Request $request): bool
    {
        $path = $request->path();

        // Ignore API routes
        if (str_starts_with($path, 'api/')) {
            return true;
        }

        // Ignore asset routes
        $assetExtensions = ['css', 'js', 'map', 'ico', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'eot'];
        foreach ($assetExtensions as $ext) {
            if (str_ends_with($path, '.' . $ext)) {
                return true;
            }
        }

        // Ignore build/hot routes (Vite)
        if (str_starts_with($path, 'build/') || $path === 'hot') {
            return true;
        }

        return false;
    }
}
