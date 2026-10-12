<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobApplication;

class HomeController extends Controller
{
    /**
     * Show the public job discovery and recruitment landing page.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::query()->with(['company', 'JobCategory'])->whereNull('deleted_at')->published();

        // Keyword filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('location', 'LIKE', "%{$location}%");
        }

        // Employment type filter
        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('type', $request->input('type'));
        }

        // Category filter
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('Category_id', $request->input('category'));
        }

        // Paginated results or featured
        $jobs = $query->latest()->paginate(9)->withQueryString();

        // Platform Metrics backed by actual data
        $stats = [
            'totalJobs' => JobVacancy::whereNull('deleted_at')->published()->count(),
            'totalCompanies' => Company::whereNull('deleted_at')->count(),
            'totalApplications' => JobApplication::whereNull('deleted_at')->count(),
            'totalCandidates' => \App\Models\User::where('role', 'job_seeker')->whereNull('deleted_at')->count(),
        ];

        // Categories with job count
        $categories = JobCategory::whereNull('deleted_at')
            ->withCount(['jobVacancies as jobs_count' => function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            }])
            ->get();

        // Top Hiring Companies
        $companies = Company::whereNull('deleted_at')
            ->withCount(['jobVacancies as vacancies_count' => function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            }])
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('jobs', 'stats', 'categories', 'companies'));
    }
}
