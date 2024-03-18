<?php

namespace App\Listeners;

use App\Events\GameSessionCompleted;
use Illuminate\Events\Dispatcher;

class GameSessionSuscriber
{

    const SCORE_MULTIPLIER = 100;

    /**
     * Handle the event.
     */
    public function handleSessionCompleted(GameSessionCompleted $event): void
    {
        $event->gameSession->update([
            'score' => ($event->gameSession->pairs / $event->gameSession->retries) * self::SCORE_MULTIPLIER
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            GameSessionCompleted::class,
            [self::class, 'handleSessionCompleted']
        );
    }
}
