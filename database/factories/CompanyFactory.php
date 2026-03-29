<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'company_cnpj' => $this->faker->numerify('##.###.###/0001-##'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
