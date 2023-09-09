<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        for($i=0; $i<= 3; $i++){
            Category::create([
                'name' => fake()->text(20),
                'parent_id' => null,
            ]);
        }

        for($i=0; $i<= 20; $i++){
            Category::create([
                'name' => fake()->text(18),
                'parent_id' => Category::inRandomOrder()->first()->id,
            ]);
        }
    }
}
