<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Public company directory.
     */
    public function index(Request $request)
    {
        $companies = Company::whereNull('deleted_at')
            ->withCount(['jobVacancies as open_jobs' => function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            }])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = trim($request->input('search'));
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('industry', 'LIKE', "%{$search}%")
                        ->orWhere('address', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('companies.index', compact('companies'));
    }

    /**
     * Public company profile with its open vacancies.
     */
    public function show($id)
    {
        $company = Company::whereNull('deleted_at')->findOrFail($id);

        $jobs = JobVacancy::whereNull('deleted_at')
            ->where('Company_id', $company->id)
            ->with(['company', 'JobCategory'])
            ->published()
            ->latest()
            ->get();

        return view('companies.show', compact('company', 'jobs'));
    }
}