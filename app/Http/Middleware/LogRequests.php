<?php

namespace App\Http\Middleware;

use App\Support\SystemLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Writes one structured entry per web request to the dedicated "system" log.
 */
class LogRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        try {
            if ($this->shouldLog($request)) {
                $status = $response->getStatusCode();
                $duration = round((microtime(true) - $start) * 1000, 2);

                $level = match (true) {
                    $status >= 500 => 'error',
                    $status >= 400 => 'warning',
                    default => 'info',
                };

                SystemLog::record(
                    sprintf('%s %s -> %d', $request->method(), $request->path(), $status),
                    [
                        'status' => $status,
                        'duration_ms' => $duration,
                        'context' => array_filter([
                            'route' => optional($request->route())->getName(),
                            'action' => optional($request->route())->getActionName(),
                        ]),
                    ],
                    $level
                );
            }
        } catch (Throwable) {
            // Logging must never break a request.
        }

        return $response;
    }

    protected function shouldLog(Request $request): bool
    {
        $route = optional($request->route())->getName();

        // Avoid a feedback loop when viewing the logs page itself.
        if (in_array($route, ['logs.index'], true)) {
            return false;
        }

        return ! $request->is('up', '_ignition/*');
    }
}
