<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category as ModelsCategory;
use Database\Factories\Category;
use Database\Factories\CategoryFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

     
       
        
        \App\Models\Produto::factory(20)->create();

        UserFactory::new()->create([
            'name' => 'Marcel Secco',
            'email' => 'marcelsecco1@gmail.com',
            'password' => bcrypt('123456789'),
            'is_admin' => true,
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
