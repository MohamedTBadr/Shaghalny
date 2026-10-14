<?php

use App\Http\Controllers\CandidateJobApplicationController;
use App\Http\Controllers\CandidateJobVacancyController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\LogWebController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/job-vacancies/{id}', [CandidateJobVacancyController::class, 'show'])->name('job-vacancies.show');

// Public discovery
Route::get('/jobs', [JobSearchController::class, 'index'])->name('jobs.index');
Route::get('/companies', [CompaniesController::class, 'index'])->name('companies.index');
Route::get('/companies/{company}', [CompaniesController::class, 'show'])->name('companies.show');
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');

// Static / informational pages
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('pages.contact.store');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');

/*
|--------------------------------------------------------------------------
| Authenticated Common / Role-Adaptive Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Role-Adaptive Dashboard (shows Job Board for job_seeker, Analytics for admin & company_owner)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Structured application log viewer (admin only)
    Route::get('/logs', [LogWebController::class, 'index'])
        ->middleware('role:admin')
        ->name('logs.index');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Candidate / Job Seeker Protected Routes (Requires Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Candidate Job Vacancy Application Submission
    Route::get('/job-vacancies/apply/{id}', [CandidateJobVacancyController::class, 'apply'])->name('job-vacancies.apply');
    Route::post('/job-vacancies/apply/{id}', [CandidateJobVacancyController::class, 'processApplication'])
        ->name('job-vacancies.process-application');

    // Candidate Application Tracking
    Route::get('/job-applications', [CandidateJobApplicationController::class, 'index'])->name('job-applications.index');
    Route::get('/job-applications/{application}', [CandidateJobApplicationController::class, 'show'])->name('job-applications.show');
});

/*
|--------------------------------------------------------------------------
| Candidate Workspace (Profile, Resume, Saved Jobs)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:job_seeker'])->group(function () {
    Route::get('/candidate/profile', [CandidateProfileController::class, 'index'])->name('candidate-profile.index');
    Route::post('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate-profile.update');

    Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
});

/*
|--------------------------------------------------------------------------
| Saved Jobs (Any authenticated role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/jobs/{job}/save', [SavedJobController::class, 'store'])->name('saved-jobs.store');
    Route::delete('/jobs/{job}/save', [SavedJobController::class, 'destroy'])->name('saved-jobs.destroy');
});

/*
|--------------------------------------------------------------------------
| Back-Office: Admin & Company Owner Shared Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,company_owner'])->group(function () {
    // Direct link to Back-Office Dashboard
    Route::get('/backoffice', [DashboardController::class, 'index'])->name('backoffice.dashboard');

    // Administrative Job Application Management (Review, Update status, Archive, Restore)
    Route::resource('/job-application', JobApplicationController::class);
    Route::put('/job-application/restore/{id}', [JobApplicationController::class, 'restore'])->name('job-application.restore');

    // Administrative Job Vacancy Management
    Route::resource('/job-vacancy', JobVacancyController::class);
    Route::post('/job-vacancy/{id}/toggle-status', [JobVacancyController::class, 'toggleStatus'])->name('job-vacancy.toggle-status');
    Route::put('/job-vacancy/restore/{id}', [JobVacancyController::class, 'restore'])->name('job-vacancy.restore');
});

/*
|--------------------------------------------------------------------------
| Back-Office: Company Owner Exclusive Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:company_owner'])->group(function () {
    Route::get('myCompany/show', [CompanyController::class, 'show'])->name('myCompany.show');
    Route::get('myCompany/edit', [CompanyController::class, 'edit'])->name('myCompany.edit');
    Route::put('myCompany/update', [CompanyController::class, 'update'])->name('myCompany.update');
});

/*
|--------------------------------------------------------------------------
| Back-Office: Admin Exclusive Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Company CRUD
    Route::resource('/company', CompanyController::class);
    Route::put('/company/restore/{id}', [CompanyController::class, 'restore'])->name('company.restore');

    // User CRUD
    Route::resource('/user', UserController::class);
    Route::put('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');

    // Job Category CRUD
    Route::resource('/job-category', JobCategoryController::class);
    Route::post('/job-category/restore/{id}', [JobCategoryController::class, 'restore'])->name('job-category.restore');
});

require __DIR__.'/auth.php';
