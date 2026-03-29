<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $companies = Company::factory(5)->create();
        }

        $companies->each(function ($company) {

            Project::factory()->count(fake()->numberBetween(2, 5))->create([
                'company_id' => $company->id,
            ]);
        });
    }

}
