<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\GameSession;
use App\Models\MemoTest;

class GameSessionQueriesTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_game_session_queries(): void
    {
        $gameSession = GameSession::factory()
                                  ->completed()
                                  ->for(MemoTest::factory()->create())
                                  ->create(['retries' => 15]);

        $this->assertNotNull($gameSession);

        $this->graphQL(/** @lang GraphQL */ '
            {
                gameSession(id: ' . $gameSession->id . ') {
                    id
                    memoTest{
                        id
                    }
                    retries
                    number_of_pairs
                    state
                    score
                }
            }
            ')->assertJson([
                    "data" => [
                        "gameSession" => [
                            "id" => $gameSession->id,
                            "memoTest" => [
                                "id" => $gameSession->memoTest->id
                            ],
                            "retries" => $gameSession->retries,
                            "number_of_pairs" => $gameSession->number_of_pairs,
                            "state" => $gameSession->state,
                            "score" => $gameSession->score
                        ]
                    ]
                ]);
    }
}
