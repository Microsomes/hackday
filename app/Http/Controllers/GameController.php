<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitFoodItemInGameRequest;
use App\Models\Game;
use App\Service\GameService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index(GameService $gameService)
    {
        $latestGame = $gameService->getRecentGame();
        $allParticipants = $latestGame->participants()->with('user')->get();

        $allFoodItems = $gameService->getRecentGameFoodItemsPerUser();

        $actionsLeft = $gameService->getUserActionLeftInGame(auth()->user());

        return Inertia::render('game/Game',[
            'players' => $allParticipants,
            'game' => $latestGame,
            'allFoodItems' => $allFoodItems,
            'actions_left'  => $actionsLeft
        ]);
    }

    public function addFoodItem(SubmitFoodItemInGameRequest $request, Game $game, GameService $gameService)
    {
        $foodItemAdded = $gameService->addFoodInGame($game, $request->validated());

        return redirect('/login')->with('success', 'Food Items Added');
    }

    public function startGame(Request $request, GameService $gameService)
    {
        $gameService->startGame();
        return 1;
    }
}
