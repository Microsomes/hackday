<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAnnonLoginRequest;
use App\Service\AuthService;
use App\Service\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{

    //just until we can point to a better looking page
    public function showLoginUgly() {}

    public function loginAnnon(UserAnnonLoginRequest $request, AuthService $authService)
    {
        $authService->authenticateUserCreateIfNotExist($request->validated()['username']);

        $isLoggedIn = Auth::check();


    return Inertia::location('/login');
    }

    public function view(GameService $gameService)
    {

        $isLoggedIn = Auth::check();

        $username = "guest";

        if ($isLoggedIn) {
            $username = auth()->user()->username;
        }

        $game = $gameService->getRecentGame();

        $isFoodSubmitted = false;

        if ($isLoggedIn) {
            //lets just join the user in the current game, hackday hacks

            $gameService->joinGame(auth()->user(), $game);

            $foodItemSubmitted = $gameService->checkIfFoodAdded($game, auth()->user());

            $isFoodSubmitted = $foodItemSubmitted;
            
        }


        return Inertia::render('game/Join', [
            'isLoggedIn' => $isLoggedIn,
            'username' => $username,
            'game' => $game,
            'gameRound' => $game->current_round,
            'food_item_submitted' => $isFoodSubmitted
        ]);
    }
}
