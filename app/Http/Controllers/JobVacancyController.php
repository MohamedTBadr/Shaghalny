<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\JobCategory;
use App\Http\Requests\JobVacancyRequest;
use App\Http\Requests\JobVacancyUpdateRequest;

class JobVacancyController extends Controller
{
    public $Types = ['Full-Time', 'Contract', 'Remote', 'Hybrid'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vacancies = JobVacancy::query()
            ->with(['company', 'JobCategory'])
            ->withCount('jobApplications')
            ->latest();

        if (auth()->user()->role === 'company_owner') {
            $vacancies->where('Company_id', auth()->user()->company->id);
        }

        if ($request->boolean('archieve')) {
            $vacancies->onlyTrashed();
        }

        $vacancies = $vacancies->simplePaginate(8)->withQueryString();

        return view('job-vacancy.index', ['Vacancies' => $vacancies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->Types;
        $categories = JobCategory::orderBy('name')->get();
        $companies = auth()->user()->role === 'admin'
            ? Company::latest()->get()
            : collect();

        return view('job-vacancy.create', compact('companies', 'types', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyRequest $request)
    {
        $data = $request->validated();

        $status = $data['status'] ?? 'published';

        $companyId = auth()->user()->role === 'company_owner'
            ? auth()->user()->company->id
            : $data['Company_id'];

        $vacancy = JobVacancy::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'location' => $data['location'],
            'salary' => $data['salary'],
            'type' => $data['type'],
            'Company_id' => $companyId,
            'Category_id' => $data['Category_id'],
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        $message = $status === 'published'
            ? 'Vacancy published successfully.'
            : 'Draft saved. Publish it when you are ready.';

        return redirect()->route('job-vacancy.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Vacancy = JobVacancy::with(['company', 'JobCategory', 'jobApplications.user'])->findOrFail($id);
            return view('job-vacancy.show', compact('Vacancy'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Job Vacancy not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $types = $this->Types;
        $categories = JobCategory::orderBy('name')->get();
        $companies = auth()->user()->role === 'admin'
            ? Company::latest()->get()
            : collect();
        $Vacancy = JobVacancy::findOrFail($id);

        return view('job-vacancy.edit', compact('Vacancy', 'types', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $Vacancy = JobVacancy::findOrFail($id);

        $status = $data['status'] ?? $Vacancy->status;

        $companyId = auth()->user()->role === 'company_owner'
            ? auth()->user()->company->id
            : $data['Company_id'];

        $Vacancy->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'location' => $data['location'],
            'salary' => $data['salary'],
            'type' => $data['type'],
            'Company_id' => $companyId,
            'Category_id' => $data['Category_id'],
            'status' => $status,
            'published_at' => $status === 'published'
                ? ($Vacancy->published_at ?? now())
                : null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return redirect()->route('job-vacancy.index')->with('success', 'Vacancy updated successfully.');
    }

    /**
     * Toggle a vacancy between draft and published.
     */
    public function toggleStatus(string $id)
    {
        $Vacancy = JobVacancy::findOrFail($id);
        $Vacancy->status = $Vacancy->status === 'published' ? 'draft' : 'published';
        $Vacancy->published_at = $Vacancy->status === 'published' ? now() : null;
        $Vacancy->save();

        $message = $Vacancy->status === 'published'
            ? 'Vacancy published successfully.'
            : 'Vacancy moved to drafts.';

        return back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $Vacancy = JobVacancy::findOrFail($id);
            $Vacancy->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(400, 'Deleted Failed');
        }
        return redirect()->route('job-vacancy.index')->with('success', 'Vacancy archived successfully.');
    }

    public function restore(string $id)
    {
        try {
            $Vacancy = JobVacancy::withTrashed()->findOrFail($id);
            $Vacancy->restore();
            return redirect()->route('job-vacancy.index')->with('success', 'Vacancy restored successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(400, "Restored Failed {$e->getMessage()}");
        }
    }
}