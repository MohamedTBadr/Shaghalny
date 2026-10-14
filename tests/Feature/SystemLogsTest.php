<?php

use App\Models\User;
use Illuminate\Support\Str;

/**
 * Point the dedicated "system" channel at a unique file inside storage/logs
 * so the test is isolated and the log viewer (which globs that directory) can
 * still find it. Returns the base path used for cleanup.
 */
function useTemporarySystemLog(): string
{
    $base = storage_path('logs'.DIRECTORY_SEPARATOR.'system-test-'.Str::lower(Str::random(8)));

    config(['logging.channels.system.path' => $base.'.log']);

    return $base;
}

function cleanupTemporarySystemLog(string $base): void
{
    foreach (glob($base.'-*.log') ?: [] as $file) {
        @unlink($file);
    }
}

function adminUser(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('login writes a structured entry to the dedicated system log', function () {
    $base = useTemporarySystemLog();

    $user = adminUser();

    try {
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $files = glob($base.'-*.log') ?: [];

        expect($files)->not->toBeEmpty();

        $contents = file_get_contents($files[0]);

        expect($contents)->toContain('User logged in');

        $lines = array_values(array_filter(preg_split('/\r\n|\n|\r/', trim($contents))));
        $entry = json_decode($lines[0], true);

        expect(json_last_error())->toBe(JSON_ERROR_NONE);
        expect($entry)->toBeArray();
        expect(array_keys($entry))->toBe([
            'time', 'level', 'channel', 'message', 'ip', 'user',
            'method', 'url', 'status', 'duration_ms', 'user_agent', 'context',
        ]);
        expect($entry['channel'])->toBe('system');
        expect($entry['level'])->toBe('INFO');
        expect($entry['message'])->toBe('User logged in');

        // Every line must be a valid JSON object (one per line).
        foreach ($lines as $line) {
            expect(json_decode($line, true))->toBeArray();
        }
    } finally {
        cleanupTemporarySystemLog($base);
    }
});

test('the system logs page renders the structured entries for an admin', function () {
    $base = useTemporarySystemLog();

    $user = adminUser();

    try {
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->get('/logs')
            ->assertOk()
            ->assertSee('System Logs')
            ->assertSee('User logged in');
    } finally {
        cleanupTemporarySystemLog($base);
    }
});

test('the system logs page requires authentication', function () {
    $this->get('/logs')->assertRedirect('/login');
});

test('the system logs page is forbidden for non-admin users', function () {
    $user = User::factory()->create(['role' => 'job_seeker']);

    $this->actingAs($user)->get('/logs')->assertForbidden();
});

test('the system logs page ignores unknown or unsafe file parameters', function () {
    $user = adminUser();

    $this->actingAs($user)
        ->get('/logs?file='.urlencode('../../.env'))
        ->assertOk();
});
