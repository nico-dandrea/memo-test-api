<?php

namespace Database\Seeders;

use Database\Seeders\GameSessionSeeder;
use Database\Seeders\MemoTestSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MemoTestSeeder::class,
            GameSessionSeeder::class,
        ]);
    }
}
