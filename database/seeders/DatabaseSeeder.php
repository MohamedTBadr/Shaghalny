<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Models\JobVacancy;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::firstOrCreate([
            'email' => 'Admin@gmail.com'
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);

        // 2. Seed Default Candidate User for testing
        User::firstOrCreate([
            'email' => 'candidate@gmail.com'
        ], [
            'name' => 'John Candidate',
            'password' => Hash::make('1234'),
            'role' => 'job_seeker',
        ]);

        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);

        // 3. Seed Job Categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // 4. Seed Companies and their Owners
        foreach ($jobData['companies'] as $comp) {
            $companyOwner = User::firstOrCreate([
                'email' => strtolower(str_replace(' ', '.', $comp['name'])) . '@example.com'
            ], [
                'name' => $comp['name'] . ' Owner',
                'password' => Hash::make('1234'),
                'role' => 'company_owner',
            ]);

            Company::firstOrCreate(
                ['name' => $comp['name']],
                [
                    'industry' => $comp['industry'],
                    'address' => $comp['address'],
                    'website' => $comp['website'],
                    'Owner_id' => $companyOwner->id,
                ]
            );
        }

        // 5. Seed Job Vacancies
        foreach ($jobData['jobVacancies'] as $job) {
            $category = JobCategory::where('name', $job['category'])->first();
            $company = Company::where('name', $job['company'])->first();

            if ($category && $company) {
                JobVacancy::firstOrCreate(
                    [
                        'title' => $job['title'],
                        'Company_id' => $company->id,
                    ],
                    [
                        'description' => $job['description'],
                        'location' => $job['location'],
                        'salary' => $job['salary'],
                        'type' => $job['type'],
                        'Category_id' => $category->id,
                        'viewCount' => rand(5, 50),
                    ]
                );
            }
        }

        // 6. Seed Job Applications and Resumes
        $jobApplicationsData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);
        if (!empty($jobApplicationsData['jobApplications'])) {
            foreach ($jobApplicationsData['jobApplications'] as $application) {
                $jobVacancy = JobVacancy::inRandomOrder()->first();
                if (!$jobVacancy) {
                    continue;
                }

                $jobSeeker = User::firstOrCreate([
                    'email' => fake()->unique()->safeEmail()
                ], [
                    'name' => fake()->name(),
                    'password' => Hash::make('1234'),
                    'role' => 'job_seeker',
                ]);

                $resume = Resume::firstOrCreate([
                    'user_id' => $jobSeeker->id,
                    'file_name' => $application['resume']['filename'] ?? 'resume.pdf',
                    'fileUrl' => $application['resume']['fileUri'] ?? 'resumes/sample.pdf',
                    'Contact_details' => is_array($application['resume']['contactDetails'] ?? null) 
                        ? json_encode($application['resume']['contactDetails']) 
                        : ($application['resume']['contactDetails'] ?? ''),
                    'skills' => is_array($application['resume']['skills'] ?? null) 
                        ? implode(', ', $application['resume']['skills']) 
                        : ($application['resume']['skills'] ?? ''),
                    'education' => is_array($application['resume']['education'] ?? null) 
                        ? json_encode($application['resume']['education']) 
                        : ($application['resume']['education'] ?? ''),
                    'experience' => is_array($application['resume']['experience'] ?? null) 
                        ? json_encode($application['resume']['experience']) 
                        : ($application['resume']['experience'] ?? ''),
                ]);

                JobApplication::firstOrCreate(
                    [
                        'JobVacancy_id' => $jobVacancy->id,
                        'user_id' => $jobSeeker->id,
                    ],
                    [
                        'resume_id' => $resume->id,
                        'status' => $application['status'] ?? 'Pending',
                        'AI_Generated_score' => $application['aiGeneratedScore'] ?? 80,
                        'AI_Generated_feedback' => $application['aiGeneratedFeedback'] ?? 'Qualified profile.',
                    ]
                );
            }
        }
    }
}
