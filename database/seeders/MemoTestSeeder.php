<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemoTest;

class MemoTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memoTest1 = MemoTest::create(['name' => 'Memo Test 1',]);
        $memoTest2 = MemoTest::create(['name' => 'Memo Test 2',]);

        $memoTest1->images()->createMany([
            ['image_url' => 'boot.png'],
            ['image_url' => 'cap.png'],
            ['image_url' => 'dress.png'],
            ['image_url' => 'hoodie.png'],
        ]);

        $memoTest2->images()->createMany([
            ['image_url' => 'jacket.png'],
            ['image_url' => 'mitten.png'],
            ['image_url' => 'shirt.png'],
            ['image_url' => 'skirt.png'],
        ]);
    }
}
