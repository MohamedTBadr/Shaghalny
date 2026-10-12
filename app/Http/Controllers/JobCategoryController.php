<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryRequest;
use Illuminate\Http\Request;

use App\Models\JobCategory; // Ensure you import the JobCategory model

use App\Http\Requests\JobCategoryUpdateRequest; // Ensure you import the JobCategoryUpdateRequest

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $Query= JobCategory::withCount('jobVacancies')->latest();
        if($request->input('archieve')){
            $Query->onlyTrashed();
        }
        $jobCategories = $Query->paginate(10);
        return view('job-category.index',['jobCategories'=> $jobCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryRequest $request)
    {
        //

        $validatedData = $request->validated();
        $jobCategory = JobCategory::create([
            'name' => $validatedData['name'],
        ]);
        return redirect()->route('job-category.index')->with('success', 'Job Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $cat= JobCategory::findOrFail($id);
        return view('job-category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        //
        $validatedData = $request->validated();
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update([
            'name' => $validatedData['name'],
        ]);
        return redirect()->route('job-category.index')->with('success', 'Job Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();
        return redirect()->route('job-category.index')->with('success', 'Job Category Archieved successfully.');
    }


    
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        //
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()->route('job-category.index')->with('success', 'Job Category Restored successfully.');
    }

}
