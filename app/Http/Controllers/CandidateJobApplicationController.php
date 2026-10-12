<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobVacancy;

class CandidateJobApplicationController extends Controller
{
    //
    public function index(Request $request)
    {
        $jobApplications = JobApplication::with(['jobVacancy.company', 'resume'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('job-applications.index', compact('jobApplications'));
    }

    public function show(Request $request, string $application)
    {
        $application = JobApplication::with(['jobVacancy.company', 'jobVacancy.JobCategory', 'resume', 'statusHistories'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($application);

        $relatedJobs = $application->jobVacancy
            ? JobVacancy::where('Category_id', $application->jobVacancy->Category_id)
                ->where('id', '!=', $application->jobVacancy->id)
                ->whereNull('deleted_at')
                ->published()
                ->with(['company', 'JobCategory'])
                ->limit(3)
                ->get()
            : collect();

        return view('job-applications.show', compact('application', 'relatedJobs'));
    }
}