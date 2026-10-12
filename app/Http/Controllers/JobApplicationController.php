<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatusHistory;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::with(['user', 'jobVacancy.company'])->latest();

        if (auth()->user()->role === 'company_owner') {
            $query->whereHas('jobVacancy', function ($q) {
                $q->where('Company_id', auth()->user()->company->id);
            });
        }

        if ($request->filled('status') && in_array($request->input('status'), ['Pending', 'Accepted', 'Rejected'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->boolean('archieve')) {
            $query->onlyTrashed();
        }

        $apps = $query->simplePaginate(8)->withQueryString();

        $scope = function () {
            $q = JobApplication::query();
            if (auth()->user()->role === 'company_owner') {
                $q->whereHas('jobVacancy', fn ($jq) => $jq->where('Company_id', auth()->user()->company->id));
            }
            return $q;
        };

        $counts = [
            'all' => $scope()->count(),
            'Pending' => $scope()->where('status', 'Pending')->count(),
            'Accepted' => $scope()->where('status', 'Accepted')->count(),
            'Rejected' => $scope()->where('status', 'Rejected')->count(),
        ];

        return view('job-application.index', compact('apps', 'counts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $app = JobApplication::with(['user', 'jobVacancy.company', 'jobVacancy.JobCategory', 'resume', 'statusHistories'])
            ->findOrFail($id);

        return view('job-application.show', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $app = JobApplication::with(['user', 'jobVacancy.company'])->findOrFail($id);

        return view('job-application.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $app = JobApplication::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Accepted,Rejected',
            'note' => 'nullable|string|max:2000',
        ]);

        $previous = $app->status;
        $app->update(['status' => $validated['status']]);

        if ($validated['status'] !== $previous) {
            ApplicationStatusHistory::create([
                'application_id' => $app->id,
                'status' => $validated['status'],
                'note' => $validated['note'] ?? null,
                'changed_by_role' => auth()->user()->role,
            ]);
        }

        $app->save();

        return redirect()->route('job-application.index')->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $app = JobApplication::findOrFail($id);
        $app->delete();

        return redirect()->route('job-application.index')->with('success', 'Application archived successfully.');
    }

    public function restore(string $id)
    {
        $app = JobApplication::withTrashed()->findOrFail($id);
        $app->restore();

        return redirect()->route('job-application.index')->with('success', 'Application restored successfully.');
    }
}