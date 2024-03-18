<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) { 
            \App\Models\MemoTest::factory()->create([
                'name' => "Memo Test $i",
            ]);
        }
    }
}
