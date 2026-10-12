<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobVacancy;

class CategoriesController extends Controller
{
    /**
     * All job categories with live vacancy counts.
     */
    public function index()
    {
        $categories = JobCategory::whereNull('deleted_at')
            ->withCount(['jobVacancies as jobs_count' => function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            }])
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Category detail with its vacancies.
     */
    public function show($id)
    {
        $category = JobCategory::whereNull('deleted_at')->findOrFail($id);

        $jobs = JobVacancy::whereNull('deleted_at')
            ->where('Category_id', $category->id)
            ->with(['company', 'JobCategory'])
            ->published()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('categories.show', compact('category', 'jobs'));
    }
}