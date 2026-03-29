<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ProfileFactory extends Factory
{

    protected $model = UserProfile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           
            'user_id' => User::factory(), 
            
           
            'user_phone' => $this->faker->phoneNumber(), 
            
           
            'user_role' => $this->faker->randomElement([
                'Administrador', 
                'Gerente de Projetos', 
                'Desenvolvedor Fullstack', 
                'Analista de QA', 
                'Suporte Técnico'
            ]),
            
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
