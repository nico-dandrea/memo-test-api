<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GameSession;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameSession>
 */
class GameSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'retries' => fake()->numberBetween(1, 65535),
            'number_of_pairs' => fake()->numberBetween(4, 15),
            'state' => fake()->randomElement(['Started', 'Completed']),
            'score' => 0,
        ];
    }

    /**
     * Indicate that the model's state should be "completed".
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'state' => 'Completed',
            ];
        })->afterCreating(function (GameSession $gameSession) {
            $gameSession->update([
                'score' => $gameSession->calculateScore,
            ]);
        });
    }
}
