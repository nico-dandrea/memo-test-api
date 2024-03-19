<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\GameSession;

final class IncrementGameSessionRetries
{
    /**
     * Increments the number of retries
     * 
     * @param mixed $root
     * @param array{id: int} $args 
     * */
    public function __invoke(mixed $root, array $args)
    {
        $gameSession = GameSession::findOrFail($args['id']);

        $gameSession->update([
            'retries' => $gameSession->retries + 1
        ]);

        return $gameSession;
    }
}
