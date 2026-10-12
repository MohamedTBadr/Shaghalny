<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    //

    public function index(Request $request){
        $user = auth()->user();
        if ($user->role === 'job_seeker') {
            $applications = JobApplication::with(['jobVacancy.company'])
                ->where('user_id', $user->id);

            $totalApplications = (clone $applications)->count();
            $pendingApplications = (clone $applications)->where('status', 'Pending')->count();
            $acceptedApplications = (clone $applications)->where('status', 'Accepted')->count();
            $savedCount = $user->savedJobs()->count();

            $recentApplications = (clone $applications)->latest()->limit(5)->get();

            $appliedCategoryIds = JobApplication::where('user_id', $user->id)
                ->whereHas('jobVacancy')
                ->get()
                ->pluck('jobVacancy.Category_id')
                ->filter()
                ->unique();

            $recommendedJobs = JobVacancy::query()
                ->with(['company', 'JobCategory'])
                ->whereNull('deleted_at')
                ->published()
                ->when($appliedCategoryIds->count(), function ($q) use ($appliedCategoryIds) {
                    return $q->whereIn('Category_id', $appliedCategoryIds)
                        ->whereNotIn('id', JobApplication::where('user_id', auth()->id())->whereHas('jobVacancy')->get()->pluck('jobVacancy.id'));
                })
                ->latest()
                ->limit(6)
                ->get();

            $profile = $user->candidateProfile;

            $stats = [
                'totalApplications' => $totalApplications,
                'pendingApplications' => $pendingApplications,
                'acceptedApplications' => $acceptedApplications,
                'savedCount' => $savedCount,
                'hasResume' => $user->resumes()->exists(),
                'hasProfile' => (bool) $profile,
            ];

            return view('dashboard-seeker', compact('recentApplications', 'recommendedJobs', 'stats'));
        }

        if ($user->role === 'admin') {
            $Analytics = $this->adminDashboard();
        } else {
            $Analytics = $this->companyOwnerDashboard();
        }
        return view('dashboard.index', compact('Analytics'));
    }


    private function adminDashboard(){
         
        $ActiveUsers=User::where('last_login_at','>=',now()->subDays(30))->where('role','job_seeker')->count();

        $totalJobs=JobVacancy::whereNull('deleted_at')->count();


        $totalApplications=JobApplication::whereNull('deleted_at')->count();
        


        $mostAppliedJobs=JobVacancy::withCount('jobApplications as totalCount')->whereNull('deleted_at')->orderby('totalCount','desc')->limit(5)->get();
        $Conversions = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->whereHas('jobApplications')
            ->orderby('totalCount', 'desc')
            ->limit(5)
            ->get()
            ->map(function($job) {
                if($job->viewCount>0){
                $job->conversionRate = $job->totalCount / $job->viewCount;
            }
            else{
                $job->conversionRate=0;
                
            }
            return $job;    
            });

                $Analytics=[
            'activeUsers'=>$ActiveUsers,
            'totalJobs'=>$totalJobs,
            'totalApplications'=>$totalApplications,
            'mostAppliedJobs'=>$mostAppliedJobs,
            'Conversions'=>$Conversions
        ];
            return $Analytics;
    }

    private function companyOwnerDashboard(){

        $company=auth()->user()->company;
        $ActiveUsers=User::where('last_login_at','>=',now()->subDays(30))
        ->where('role','job_seeker')
        ->whereHas('jobApplications',function($query)use ($company){
            $query->whereIn('JobVacancy_id',$company->jobVacancies->pluck('id'));
        })->count();

        

        $totalJobs=$company->jobVacancies->count();

        $totalApplications=JobApplication::whereIn('JobVacancy_id',$company->jobVacancies->pluck('id'))->count();

        $mostAppliedJobs=JobVacancy::withCount('jobApplications as totalCount')->whereIn('id',$company->jobVacancies->pluck('id'))->orderby('totalCount','desc')->limit(5)->get();


        $Conversions = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id',$company->jobVacancies->pluck('id'))
            ->whereHas('jobApplications')
            ->orderby('totalCount', 'desc')
            ->limit(5)
            ->get()
            ->map(function($job) {
                if($job->viewCount>0){
                $job->conversionRate = $job->totalCount / $job->viewCount;
            }
            else{
                $job->conversionRate=0;
                
            }
            return $job;    
            });



        $Analytics=[
            'activeUsers'=>$ActiveUsers,
            'totalJobs'=>$totalJobs,
            'totalApplications'=>$totalApplications,
            'mostAppliedJobs'=>$mostAppliedJobs,
            'Conversions'=>$Conversions
        ];
        return $Analytics;

    }

}


