<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MemoTest;

class MemoTestTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_queries_memo_test(): void
    {
        $memoTest = MemoTest::factory()
                            ->hasImages(2)
                            ->create();
                                    
        $this->graphQL(/** @lang GraphQL */ '
        {
            memoTest(id: '.$memoTest->id.') {
                id
                name
                images {
                    id
                }
            }
        }
        ')->assertJson([
            'data' => [
                'memoTest' => [
                    'id' => $memoTest->id,
                    'name' => $memoTest->name,
                    'images' => [
                        [
                            'id' => $memoTest->images[0]->id
                        ],
                        [
                            'id' => $memoTest->images[1]->id
                        ]
                    ]
                ]
            ]
        ]);
    }
}
