<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    /**
     * Full public job search with filters, sorting and pagination.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::query()
            ->with(['company', 'JobCategory'])
            ->whereNull('deleted_at')
            ->published();

        // Keyword: title, description, or company name
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('company', function ($cq) use ($search) {
                        $cq->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Location
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . trim($request->input('location')) . '%');
        }

        // Employment type
        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('type', $request->input('type'));
        }

        // Category
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('Category_id', $request->input('category'));
        }

        // Minimum salary threshold
        if ($request->filled('min_salary') && is_numeric($request->input('min_salary'))) {
            $query->where('salary', '>=', (float) $request->input('min_salary'));
        }

        // Sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'salary-high':
                $query->orderByDesc('salary');
                break;
            case 'salary-low':
                $query->orderBy('salary');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest();
                break;
        }

        $jobs = $query->paginate(12)->withQueryString();

        $categories = JobCategory::whereNull('deleted_at')
            ->withCount(['jobVacancies as jobs_count' => function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        $types = [
            'Full-Time',
            'Part-Time',
            'Remote',
            'Hybrid',
            'Contract',
            'Freelance',
            'Internship',
        ];

        return view('jobs.index', compact('jobs', 'categories', 'types'));
    }
}