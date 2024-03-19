<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\GameSession;

final class EndGameSession
{
    /** @param  array{id: int}  $args */
    public function __invoke(mixed $_, array $args): GameSession|array
    {
        $gameSession = GameSession::find($args['id']);

        if ($gameSession->state === 'Completed') {
            return [
                'error' => 'Session already completed'
            ];
        }

        $gameSession->update([
            'score' => GameSession::SCORE_MULTIPLIER * ($gameSession->pairs * $gameSession->retries),
            'state' => 'Completed'
        ]);

        return $gameSession;
    }
}
