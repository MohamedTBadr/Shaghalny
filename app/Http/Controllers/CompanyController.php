<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyUpdateRequest;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure you import the User model

use App\Models\Company; // Ensure you import the Company model
use App\Models\JobApplication;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{

    public $industries = [
        'Technology',
        'Finance',
        'Healthcare',
        'Education',
        'Retail',
        'Manufacturing',
        'Hospitality',
        'Construction',
        'Transportation',
        'Real Estate',
        'Energy',
        'Telecommunications',
        'Entertainment',
        'Government',
        'Non-Profit'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::with('owner')->withCount('jobVacancies');
        if($request->input('archieve')) {
            $companies =$companies->onlyTrashed();
        }

        $companies = $companies->latest()->paginate(10);

        //
        return view('company.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $owners = User::where('role', 'company_owner')
            ->whereNull('deleted_at') // Ensure we only get non-deleted company owners
            ->get(); // Get only the name and id fields
            $industries = $this->industries; // Get the industries from the controller property
        return view('company.create',[
            'owners' => $owners,'industries' => $industries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        //
        $ValidatedData= $request->validated();
        
        $owner=User::create([
            'name' => $ValidatedData['Owner_Name'],
            'email' => $ValidatedData['Owner_Email'],
            'password' => Hash::make($ValidatedData['Owner_Password']),
            'role' => 'company_owner', // Set the role to company_owner
        ]);
        if(!$owner) {
            return redirect()->back()->with('error', 'Failed to create company owner.');
        }
        Company::create([
            'name' => $ValidatedData['name'],
            'address' => $ValidatedData['address'],
            'industry' => $ValidatedData['industry'],
            'website' => $ValidatedData['website'],
            'Owner_id' => $owner->id, // Use the created owner's ID
        ]);
        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(?string $id=null)
    {
        //
        $company=$this->getCompany($id);
        $company->load('owner');
        $company->loadCount('jobVacancies');

        $applications = JobApplication::with(['user', 'jobVacancy'])
            ->whereIn('JobVacancy_id', $company->jobVacancies()->pluck('id'))
            ->latest()
            ->limit(50)
            ->get();

        return view('company.show', compact('company', 'applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?string $id =null)
    {
        //
        $company=$this->getCompany($id);

        $owners = User::where('role', 'company_owner')
            ->whereNull('deleted_at') // Ensure we only get non-deleted company owners
            ->get(); // Get only the name and id fields
        // $company->load('owner'); // Load the owner relationship if needed
        if (!$company) {
            return redirect()->route('company.index')->with('error', 'Company not found.');
        }
        return view('company.edit', ['company' => $company, 'owners' => $owners]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, ?string $id=null)
    {
        //
          $company=$this->getCompany($id);
        
        $ValidatedData = $request->validated();
        $company->update([
            'name'=>$ValidatedData['name'],
            'address'=>$ValidatedData['address'],
            'industry'=>$ValidatedData['industry'],
            'website'=>$ValidatedData['website'],
        ]);

        $ownerData=[];
        $ownerData['name']=$ValidatedData['Owner_Name'];
        if($ValidatedData['Owner_Password']){
            $ownerData['password']=Hash::make($ValidatedData['Owner_Password']);
        }

        $company->owner->update($ownerData);

        if(auth()->user()->role=='company_owner'){
                        return redirect()->route('myCompany.show',)->with('success', 'Company updated successfully.');

        }


        if($request->query('redirectToList')==true){
            
            return redirect()->route('company.show',$id)->with('success', 'Company updated successfully.');
        }
        return redirect()->route('company.index')->with('success', 'Company updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company archived successfully.');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index')->with('success', 'Company restored successfully.');
    }


    private function getCompany(?string $id=null){
        if($id){
            $company = Company::findOrFail($id);
        }else{
            $company=Company::where('Owner_id',auth()->user()->id)->first();
        }
        return $company;
    }
}
