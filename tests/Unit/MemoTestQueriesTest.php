<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MemoTest;

class MemoTestQueriesTest extends TestCase
{
    /**
     * Test memo test queries.
     */
    public function test_basic_memo_test_query(): void
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
                    image_url
                }
            }
        }
        ')->assertJson([
            "data" => [
                "memoTest" => [
                    "id" => $memoTest->id,
                    "name" => $memoTest->name,
                    "images" => [
                        [
                            "id" => $memoTest->images[0]->id,
                            "image_url" => $memoTest->images[0]->image_url
                        ],
                        [
                            "id" => $memoTest->images[1]->id,
                            "image_url" => $memoTest->images[1]->image_url
                        ]
                    ]
                ]
            ]
        ]);
        
    }

    /**
     * Test memo test queries.
     */
    public function test_memo_test_count(): void
    {
        MemoTest::factory()
                ->hasImages(2)
                ->count(5)
                ->create();

        $this->graphQL(/** @lang GraphQL */ '
        {
            memoTests {
                id
            }
        }
        ')->assertJsonCount(5, "data.memoTests");
    }
}
