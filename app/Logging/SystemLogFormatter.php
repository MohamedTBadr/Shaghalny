<?php

namespace App\Logging;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

/**
 * Formats a Monolog record as a single JSON object (one per line) with a
 * fixed, stable structure so the "System Logs" viewer can render every entry.
 */
class SystemLogFormatter implements FormatterInterface
{
    private const RESERVED = ['ip', 'user', 'method', 'url', 'status', 'duration_ms', 'user_agent'];

    public function format(LogRecord $record): string
    {
        $context = $record->context;

        $ip = $this->pull($context, 'ip');
        $user = $this->pull($context, 'user');
        $method = $this->pull($context, 'method');
        $url = $this->pull($context, 'url');
        $status = $this->pull($context, 'status');
        $duration = $this->pull($context, 'duration_ms');
        $userAgent = $this->pull($context, 'user_agent');

        $data = [
            'time' => $record->datetime->format('Y-m-d H:i:s'),
            'level' => strtoupper($record->level->getName()),
            'channel' => $record->channel,
            'message' => $record->message,
            'ip' => $ip,
            'user' => $user,
            'method' => $method,
            'url' => $url,
            'status' => $status,
            'duration_ms' => $duration,
            'user_agent' => $userAgent,
            'context' => $context,
        ];

        $json = json_encode(
            $data,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
        );

        if ($json === false) {
            $json = json_encode([
                'time' => $data['time'],
                'level' => $data['level'],
                'channel' => $data['channel'],
                'message' => $data['message'],
                'context' => ['_encoding_error' => json_last_error_msg()],
            ], JSON_INVALID_UTF8_SUBSTITUTE) ?: '{}';
        }

        return $json.PHP_EOL;
    }

    public function formatBatch(array $records): string
    {
        $out = '';

        foreach ($records as $record) {
            $out .= $this->format($record);
        }

        return $out;
    }

    /**
     * Remove a reserved key from the context so it can be lifted to the top level.
     */
    private function pull(array &$context, string $key): mixed
    {
        if (! array_key_exists($key, $context)) {
            return null;
        }

        $value = $context[$key];
        unset($context[$key]);

        return $value;
    }
}
