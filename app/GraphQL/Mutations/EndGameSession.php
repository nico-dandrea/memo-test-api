<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\GameSession;

final class EndGameSession
{
    /**
     * Sets the state of the GameSession to Completed and calculates the score
     * 
     * @param mixed $root
     * @param array{id: int} $args 
     * */
    public function __invoke(mixed $root, array $args): GameSession
    {
        $gameSession = GameSession::findOrFail($args['id']);
        $score = 0;

        if ($gameSession->retries !== 0) {
            $score = GameSession::SCORE_MULTIPLIER * ($gameSession->pairs * $gameSession->retries);
        }

        $gameSession->update([
            'score' => $score,
            'state' => 'Completed'
        ]);

        return $gameSession;
    }
}
