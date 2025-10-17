<?php

namespace App\Service;

use App\Models\Game;
use App\Models\GameParticipants;
use App\Models\User;

class GameService
{

    public function joinGame(User $user, Game $game): bool
    {
        //check if user is not already apart of the game

        $exists = GameParticipants::where([
            'game_id' => $game->id,
            'user_id' => $user->id
        ])->exists();

        if (!$exists) {
            GameParticipants::create([
                'game_id' => $game->id,
                'user_id' => $user->id
            ]);

            return true;
        }

        return true;
    }

    public function addFoodInGame(Game $game) {}


    //if one doesnt exist we should create one
    public function getRecentGame(): Game
    {
        $game = Game::where('current_round', '!=', 4)
            ->latest()
            ->first();

        if (!$game) {
            $createdGame = Game::create([
                'name' => 'Appoly Breakfast Wars',
                'current_round' => 0
            ]);

            return $createdGame;
        }

        return $game;
    }
}
