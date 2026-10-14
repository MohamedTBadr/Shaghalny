<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\ApplicationStatusHistory;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;

class CandidateJobVacancyController extends Controller
{
    //
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show($id)
    {
        $jobVacancy = JobVacancy::with(['company', 'JobCategory'])->findOrFail($id);

        $isOwner = auth()->check() && (
            auth()->user()->role === 'admin'
            || (auth()->user()->role === 'company_owner' && auth()->user()->company?->id === $jobVacancy->Company_id)
        );

        abort_unless($jobVacancy->isPublished() || $isOwner, 404);

        $jobVacancy->increment('viewCount');

        $relatedJobs = JobVacancy::where('Category_id', $jobVacancy->Category_id)
            ->where('id', '!=', $id)
            ->with(['company', 'JobCategory'])
            ->whereNull('deleted_at')
            ->published()
            ->limit(3)
            ->get();

        return view('job-vacancies.show', compact('jobVacancy', 'relatedJobs'));
    }

    public function apply($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        abort_unless($jobVacancy->isPublished(), 404);
        $resumes = auth()->user()->resumes;

        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        abort_unless($jobVacancy->isPublished(), 404);
        $extractedInfo = null;
        $resumeId = null;
        if ($request->input('resume_option') === 'new_resume') {
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $orignalFileName = $file->getClientOriginalName();
            // unique for avoiding overriding
            $fileName = 'resume_'.time().'.'.$extension;

            // storing

            $path = $file->storeAs('resumes', $fileName, 'local');
            $fileUrl = $path;

            // TODO
            $extractedInfo = $this->resumeAnalysisService->extractResumeInfromation($fileUrl);

            $resume = Resume::create([
                'file_name' => $orignalFileName,
                'fileUrl' => $path,
                'user_id' => auth()->id(),
                'Contact_details' => json_encode([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]),
                'summary' => $extractedInfo['summary'],
                'education' => $extractedInfo['education'],
                'skills' => $extractedInfo['skills'],
                'experience' => $extractedInfo['experience'],
            ]);
            $resumeId = $resume->id;

        } else {
            $resumeId = $request->input('resume_option');
            $resume = Resume::where('user_id', auth()->id())->findOrFail($resumeId);

            $extractedInfo = [
                'summary' => $resume->summary,
                'education' => $resume->education,
                'skills' => $resume->skills,
                'experience' => $resume->experience,
            ];

            // Fallback: if this resume was stored before its contents were parsed
            // (or parsing failed), extract them now and persist them.
            if (trim(implode('', array_map('strval', $extractedInfo))) === '') {
                $extractedInfo = $this->resumeAnalysisService->extractResumeInfromation($resume->fileUrl);
                $resume->update($extractedInfo);
            }
        }
        // TODO Evaluate Job App
        $evalution = $this->resumeAnalysisService->analyzeResume($jobVacancy, $extractedInfo);

        $application = JobApplication::create([
            'status' => 'Pending',
            'JobVacancy_id' => $id,
            'resume_id' => $resumeId,
            'user_id' => auth()->id(),
            'AI_Generated_score' => $evalution['AI_Generated_score'],
            'AI_Generated_feedback' => $evalution['AI_Generated_feedback'],

        ]);

        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'status' => 'Pending',
            'note' => 'Application submitted',
            'changed_by_role' => 'candidate',
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Applied successfully');
    }
}
