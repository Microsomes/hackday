<?php

namespace App\Service;

use App\Events\GameStarted;
use App\Models\FoodItems;
use App\Models\Game;
use App\Models\GameParticipants;
use App\Models\GameRound;
use App\Models\User;

class GameService
{


    public function startGame()
    {
        $game = $this->getRecentGame();
        // ^ we are about to start this game now

        $game->update([
            'current_round' => 1
        ]);

        GameStarted::dispatch(
            $game
        );
    }

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



    public function checkIfFoodAdded(Game $game, User $user): bool
    {
        $gameParticipant = GameParticipants::where([
            'game_id' => $game->id,
            'user_id' => $user->id
        ])->first();

        $mainKey = $game->id . '_' . $gameParticipant->id . '_main';
        $sideKey = $game->id . '_' . $gameParticipant->id . '_side';
        $drinkKey = $game->id . '_' . $gameParticipant->id . '_drink';

        $mainExists = FoodItems::where('unique_key', $mainKey)->exists();

        return $mainExists;
    }

    //returns list of users who never submitted their food
    public function checkWaitingOn(Game $game): array
    {
        $gameParticipants = GameParticipants::where([
            'game_id' => $game->id,
        ])->get();

        $allPeopleWaitingOn = [];

        foreach($gameParticipants as $participant)
        {
            $username = $participant->user->username;
            $hasAdded = $this->checkIfFoodAdded($game,$participant->user);
            if(!$hasAdded)
            {
                $allPeopleWaitingOn[] = $username;
            }
        }

        return $allPeopleWaitingOn;
    }

    public function addFoodInGame(Game $game, array $data): bool
    {

        $gameParticipant = GameParticipants::where([
            'game_id' => $game->id,
            'user_id' => auth()->user()->id
        ])->first();

        FoodItems::create([
            'game_id' => $game->id,
            'game_participant_id' => $gameParticipant->id,
            'food_name' => $data['main'],
            'type' => 'main',
            'unique_key' => $game->id . '_' . $gameParticipant->id . '_main'
        ]);

        FoodItems::create([
            'game_id' => $game->id,
            'game_participant_id' => $gameParticipant->id,
            'food_name' => $data['side'],
            'type' => 'side',
            'unique_key' => $game->id . '_' . $gameParticipant->id . '_side'
        ]);

        FoodItems::create([
            'game_id' => $game->id,
            'game_participant_id' => $gameParticipant->id,
            'food_name' => $data['drink'],
            'type' => 'drink',
            'unique_key' => $game->id . '_' . $gameParticipant->id . '_drink'
        ]);

        return true;
    }

    public function getUserActionLeftInGame(User $user)
    {
        $game = $this->getRecentGame();

        $gameParticipant = GameParticipants::where([
            'user_id' => $user->id,
            'game_id' => $game->id
        ])->first();

        $gameRounds = GameRound::where([
            'game_id' => $game->id,
            'game_participant_id' => $gameParticipant->id,
        ])->get();

        $actionsLeft = [];

        if ($gameRounds->count() == 0) {
            $actionsLeft = [
                'steal',
                'defend',
                'swap'
            ];
        }

        return [
            'actionsLeft' => $actionsLeft
        ];
    }

    public function getRecentGameFoodItemsPerUser()
    {
        $game = $this->getRecentGame();
        $partcipants = $game->participants()->with(['user:id,username'])->get();

        $userFoodItem = [];

        foreach ($partcipants as $partcipant) {
            $allFoods = FoodItems::where([
                'game_id' => $game->id,
                'game_participant_id' => $partcipant->id
            ])->get();

            $userFoodItem[$partcipant->user->username] = $allFoods;
        }

        return [
            'partcipants' => $partcipants,
            'userFoodItem' => $userFoodItem
        ];
    }

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
