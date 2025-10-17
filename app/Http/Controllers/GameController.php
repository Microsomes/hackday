<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitFoodItemInGameRequest;
use App\Models\Game;
use App\Service\GameService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index()
    {
        return Inertia::render('game/Game');
    }

    public function addFoodItem(SubmitFoodItemInGameRequest $request, Game $game, GameService $gameService)
    {
        dd($request->validated(), $game->id);
    }
}
