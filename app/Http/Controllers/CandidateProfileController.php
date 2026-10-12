<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
    /**
     * Show the candidate's profile editor.
     */
    public function index(Request $request)
    {
        $profile = $request->user()->candidateProfile ?: new \App\Models\CandidateProfile();

        return view('candidate-profile.index', compact('profile'));
    }

    /**
     * Create or update the candidate profile.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'headline' => ['nullable', 'string', 'max:190'],
            'bio' => ['nullable', 'string', 'max:4000'],
            'location' => ['nullable', 'string', 'max:190'],
            'experience_level' => ['nullable', 'string', 'in:Entry,Mid,Senior,Lead,Manager'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'industries' => ['nullable', 'string', 'max:1000'],
            'open_to_remote' => ['nullable', 'boolean'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();

        $user->candidateProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'headline' => $validated['headline'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'location' => $validated['location'] ?? null,
                'experience_level' => $validated['experience_level'] ?? null,
                'skills' => $this->toArray($validated['skills'] ?? null),
                'industries' => $this->toArray($validated['industries'] ?? null),
                'open_to_remote' => $request->boolean('open_to_remote'),
                'is_available' => $request->boolean('is_available'),
            ]
        );

        return back()->with('success', 'Your profile has been updated.');
    }

    private function toArray(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        $items = array_filter(array_map('trim', explode(',', $value)));

        return $items ? array_values($items) : null;
    }
}