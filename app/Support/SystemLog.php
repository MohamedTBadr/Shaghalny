<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Thin, failure-proof helper around the dedicated "system" log channel.
 *
 * Every entry is enriched with request context (ip, method, url, user agent,
 * user) before it is written to the structured JSON channel. Logging failures
 * are always swallowed so they can never break an application request.
 */
class SystemLog
{
    public static function record(string $message, array $context = [], string $level = 'info'): void
    {
        // Allow callers to nest extra data under a 'context' key.
        if (isset($context['context']) && is_array($context['context'])) {
            $context = array_merge($context, $context['context']);
            unset($context['context']);
        }

        try {
            Log::channel('system')->log($level, $message, array_merge(static::requestContext(), $context));
        } catch (Throwable $e) {
            try {
                Log::channel('single')->error('SystemLog failed: '.$e->getMessage());
            } catch (Throwable) {
                // Never let logging break the request.
            }
        }
    }

    public static function debug(string $message, array $context = []): void
    {
        static::record($message, $context, 'debug');
    }

    public static function info(string $message, array $context = []): void
    {
        static::record($message, $context, 'info');
    }

    public static function notice(string $message, array $context = []): void
    {
        static::record($message, $context, 'notice');
    }

    public static function warning(string $message, array $context = []): void
    {
        static::record($message, $context, 'warning');
    }

    public static function error(string $message, array $context = []): void
    {
        static::record($message, $context, 'error');
    }

    public static function critical(string $message, array $context = []): void
    {
        static::record($message, $context, 'critical');
    }

    /**
     * Generic activity helper: same as record() but reads naturally at call sites.
     */
    public static function activity(string $activity, array $context = [], string $level = 'info'): void
    {
        static::record($activity, $context, $level);
    }

    protected static function requestContext(): array
    {
        $ctx = [];

        if (! app()->runningInConsole() && app()->bound('request')) {
            try {
                $request = request();
                $ctx['ip'] = $request->ip();
                $ctx['method'] = $request->method();
                $ctx['url'] = $request->fullUrl();
                $ctx['user_agent'] = mb_substr((string) $request->userAgent(), 0, 255);
            } catch (Throwable) {
                // ignore request introspection failures
            }
        }

        $ctx['user'] = static::currentUsername();

        return array_filter($ctx, static fn ($value) => $value !== null && $value !== '');
    }

    protected static function currentUsername(): ?string
    {
        try {
            $user = auth()->user();

            if ($user) {
                return $user->name ?? $user->email ?? null;
            }

            // Legacy/session-based fallback (kept for compatibility).
            $sessionUser = session('user');

            if (is_object($sessionUser)) {
                return $sessionUser->username ?? $sessionUser->name ?? null;
            }

            if (is_array($sessionUser)) {
                return $sessionUser['username'] ?? $sessionUser['name'] ?? null;
            }
        } catch (Throwable) {
            // ignore
        }

        return null;
    }
}
