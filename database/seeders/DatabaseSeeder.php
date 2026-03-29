<?php

namespace Database\Seeders;

use App\Models\TicketDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'admin@teste.com',
        ]);
        
        User::factory(10)->create();


        $this->call([
           
            CompanySeeder::class,      
            
            ProfileSeeder::class,  
            ProjectSeeder::class,      
            
            
            TicketSeeder::class,       
            DetailSeeder::class, 
        ]);
    }
}
