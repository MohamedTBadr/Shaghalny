<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    /**
     * List the authenticated user's saved vacancies.
     */
    public function index(Request $request)
    {
        $savedJobs = $request->user()->savedJobs()
            ->whereHas('jobVacancy', fn ($q) => $q->whereNull('deleted_at')->where('status', 'published'))
            ->with(['jobVacancy.company', 'jobVacancy.JobCategory'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('saved-jobs.index', compact('savedJobs'));
    }

    /**
     * Save a vacancy. Idempotent.
     */
    public function store(Request $request, JobVacancy $job)
    {
        abort_if($job->trashed(), 404);

        $request->user()->savedJobs()->firstOrCreate(['job_vacancy_id' => $job->id]);

        return back()->with('success', 'Job saved. Find it anytime under Saved Jobs.');
    }

    /**
     * Remove a vacancy from saved jobs. Idempotent.
     */
    public function destroy(Request $request, JobVacancy $job)
    {
        $request->user()->savedJobs()->where('job_vacancy_id', $job->id)->delete();

        return back()->with('success', 'Job removed from your saved list.');
    }
}