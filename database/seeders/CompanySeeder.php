<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;



class CompanySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $jobData=json_decode(file_get_contents(database_path('data/job_data.json')), true);

        foreach($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        foreach($jobData['companies'] as $company) {
            $companyOwner=User::firstOrCreate([
                'email' => fake()->unique()->safeEmail() // Generate a unique email for the company owner,
            ], [
                'name' => fake()->name(), // Generate a random name for the company owner
                'password' => Hash::make('1234'), // Ensure to hash the password
                'role' => 'company_owner', // Assuming you have a role field in your User model
            ]);

           
                // Company::firstOrCreate([
                //     'name' => $company['name']
                     
                //  ],[
                //      'industry' => $company['industry'],
                //      'address' => $company['address'],
                //      'website' => $company['website'],
                //      'Owner_id' => $companyOwner->id, // Link to the company owner
                //  ]);

                Company::firstOrCreate(
                    ['name' => $company['name']],
                    [
                        'industry' => $company['industry'],
                        'address' => $company['address'],
                        'website' => $company['website'],
                        'Owner_id' => $companyOwner->id, // Link to the company owner
                    ]
                );
            
        }
    }
}
