<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $Query=User::latest();
        if($request->input('archieve')){
            $Query->onlyTrashed();
        };
        $users=$Query->paginate(10);
        return view('user.index',compact('users'));
        


    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user=User::withTrashed()->withCount(['jobApplications', 'resumes'])->findOrFail($id);
        $user->load(['candidateProfile', 'company']);
        $recentApplications = $user->jobApplications()->with('jobVacancy')->latest()->limit(10)->get();
        return view('user.show',compact('user', 'recentApplications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user=User::findOrFail($id);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user=User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'company_owner', 'job_seeker'])],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }
        $user->save();

        return redirect()->route('user.show', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user=User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');

    }

    public function restore(string $id)
    {
        $user=User::withTrashed()->findOrFail($id);
        $user->restore();
                return redirect()->route('user.index')->with('success', 'User Restored successfully.');



    }
}
