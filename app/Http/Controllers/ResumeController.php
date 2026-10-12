<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ResumeController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    /**
     * List the authenticated user's resumes.
     */
    public function index(Request $request)
    {
        $resumes = $request->user()->resumes()->latest()->get();

        return view('resumes.index', compact('resumes'));
    }

    /**
     * Upload a new resume and run the extraction pipeline.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resume_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $file = $validated['resume_file'];
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $storedName = 'resume_' . uniqid() . '.' . $extension;

        $path = $file->storeAs('resumes', $storedName, 'cloud');
        $fileUrl = $path;

        $extracted = $this->resumeAnalysisService->extractResumeInfromation($fileUrl);

        Resume::create([
            'file_name' => $originalName,
            'fileUrl' => $path,
            'user_id' => $request->user()->id,
            'Contact_details' => json_encode([
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ]),
            'summary' => $extracted['summary'],
            'education' => $extracted['education'],
            'skills' => $extracted['skills'],
            'experience' => $extracted['experience'],
        ]);

        return redirect()->route('resumes.index')->with('success', 'Resume uploaded successfully.');
    }

    /**
     * Securely download one of the user's own resumes.
     */
    public function download(Request $request, Resume $resume)
    {
        abort_if($resume->trashed(), 404);
        abort_unless($resume->user_id === $request->user()->id, 403);

        return Storage::disk('cloud')->download(
            $resume->fileUrl,
            $resume->file_name
        );
    }

    /**
     * Delete one of the user's own resumes and its stored file.
     */
    public function destroy(Request $request, Resume $resume)
    {
        abort_unless($resume->user_id === $request->user()->id, 403);

        try {
            Storage::disk('cloud')->delete($resume->fileUrl);
        } catch (\Exception $e) {
            Log::warning('Failed to delete resume file ' . $resume->id . ': ' . $e->getMessage());
        }

        $resume->delete();

        return back()->with('success', 'Resume deleted.');
    }
}