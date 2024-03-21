<?php

namespace Database\Seeders;

use App\Models\MemoTest;
use Illuminate\Database\Seeder;
use App\Models\GameSession;

class GameSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GameSession::factory()->completed()->count(5)->for(MemoTest::first())->create(
            ['number_of_pairs' => 4]
        );
    }
}
