<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LogWebController extends Controller
{
    /**
     * Maximum number of entries rendered from a single file.
     */
    protected const MAX_ENTRIES = 1000;

    /**
     * Maximum number of bytes read from the tail of a log file.
     */
    protected const MAX_READ_BYTES = 4194304; // 4 MB

    /**
     * Display the "System Logs" viewer.
     */
    public function index(Request $request): View
    {
        $directory = storage_path('logs');

        $logFiles = $this->availableLogFiles($directory);

        $selectedFile = $request->query('file');

        if (! is_string($selectedFile) || ! in_array($selectedFile, $logFiles, true)) {
            $selectedFile = $logFiles[0] ?? null;
        }

        $logs = $selectedFile !== null
            ? $this->readEntries($directory.DIRECTORY_SEPARATOR.$selectedFile)
            : [];

        return view('logs.index', compact('logFiles', 'logs', 'selectedFile'));
    }

    /**
     * List available log files, newest first, with "system*" files grouped first.
     *
     * @return array<int, string>
     */
    protected function availableLogFiles(string $directory): array
    {
        if (! File::isDirectory($directory)) {
            return [];
        }

        $names = [];

        foreach (File::glob($directory.DIRECTORY_SEPARATOR.'*.log') ?: [] as $file) {
            $names[] = basename($file);
        }

        usort($names, function (string $a, string $b) use ($directory): int {
            $aGroup = str_starts_with($a, 'system') ? 0 : 1;
            $bGroup = str_starts_with($b, 'system') ? 0 : 1;

            if ($aGroup !== $bGroup) {
                return $aGroup <=> $bGroup;
            }

            $aTime = @filemtime($directory.DIRECTORY_SEPARATOR.$a) ?: 0;
            $bTime = @filemtime($directory.DIRECTORY_SEPARATOR.$b) ?: 0;

            return $bTime <=> $aTime;
        });

        return $names;
    }

    /**
     * Parse a log file (tail-limited) into an array of structured entries,
     * newest first. Non-JSON lines fall back to a plain message entry.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function readEntries(string $path): array
    {
        if (! File::isFile($path)) {
            return [];
        }

        $size = @filesize($path);

        if (! is_int($size) || $size === 0) {
            return [];
        }

        $handle = @fopen($path, 'rb');

        if ($handle === false) {
            return [];
        }

        $read = min($size, self::MAX_READ_BYTES);

        fseek($handle, $size - $read);
        $data = fread($handle, $read);
        fclose($handle);

        if ($data === false) {
            return [];
        }

        // Drop a possibly partial first line when we only read the tail.
        if ($read < $size) {
            $firstNewline = strpos($data, "\n");

            if ($firstNewline !== false) {
                $data = substr($data, $firstNewline + 1);
            }
        }

        $lines = preg_split('/\r\n|\n|\r/', $data) ?: [];
        $lines = array_slice($lines, -self::MAX_ENTRIES);

        $entries = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $decoded = json_decode($line, true);

            if (is_array($decoded)) {
                $decoded['level'] = strtoupper((string) ($decoded['level'] ?? 'UNKNOWN'));
                $entries[] = $decoded;
            } else {
                $entries[] = [
                    'time' => '',
                    'level' => 'UNKNOWN',
                    'message' => $line,
                ];
            }
        }

        return array_reverse($entries);
    }
}
