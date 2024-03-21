<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\GameSession;
use App\Models\MemoTest;

class GameSessionMutationsTest extends TestCase
{
    /**
     * Testing create game session
     */
    public function test_create_game_session(): void
    {
        $memoTest = MemoTest::factory()->hasImages(4)->create();

        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createGameSession(
                    input: 
                        { 
                            memoTest: { connect: ' . $memoTest->id . ' },
                            number_of_pairs: ' . $memoTest->images->count() . '
                        }
                    ) {
                    id
                    memoTest {
                        id
                    }
                }
                }
        ');

        $gameSession = GameSession::find($response->json('data.createGameSession.id'));

        $this->assertNotNull($gameSession);

        $response->assertJson([
            'data' => [
                'createGameSession' => [
                    'id' => $gameSession->id,
                    'memoTest' => [
                        'id' => $gameSession->memoTest->id
                    ]
                ]
            ]
        ]);
    }

    /**
     * Testing increment game session retries
     */
    function test_increment_game_session_retries(): void
    {
        $gameSession = GameSession::factory()
            ->for(
                MemoTest::factory()
                    ->hasImages(4)
                    ->create()
            )->create();

        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                incrementGameSessionRetries(
                    input: {
                        id: ' . $gameSession->id . '
                    }
                ) {
                    id
                    retries
                }
            }
        ');

        $this->assertEquals($gameSession->retries + 1, $response->json('data.incrementGameSessionRetries.retries'));
    }

    /**
     * Testing end game session
     */
    function test_end_game_session(): void
    {
        $gameSession = GameSession::factory()
            ->for(
                MemoTest::factory()
                    ->hasImages(4)
                    ->create()
            )
            ->create(['retries' => 12, 'number_of_pairs' => 4]);

        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                endGameSession(
                    input: {
                        id: ' . $gameSession->id . '
                    }
                ) {
                    id
                    state
                    retries
                    number_of_pairs
                    score
                }
            }
        ');

        $this->assertEquals('Completed', $response->json('data.endGameSession.state'));

        $score = round(100 * ($response->json('data.endGameSession.number_of_pairs') / $response->json('data.endGameSession.retries')));

        $this->assertEquals($score, $response->json('data.endGameSession.score'));
    }
}
