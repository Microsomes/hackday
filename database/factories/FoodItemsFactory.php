<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameParticipants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodItems>
 */
class FoodItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'game_participant_id' => GameParticipants::factory(),
            'food_name' => fake()->name(),
            'type' => fake()->randomElement([
                'drink',
                'side',
                'main'
            ]),
            'unique_key' => fake()->uuid()
        ];
    }
}
