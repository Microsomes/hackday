<?php

use App\Events\GameStarted;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Service\GameService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [GameController::class, 'index'])->name('game');


Route::get('/testevent', function(){
    GameStarted::dispatch('hello');

    return 1;
});

Route::get('/listen', function (){
    return Inertia::render('listen',[]);
});


Route::get('/login', [AuthController::class, 'view']);
Route::post('/loginAnnon', [AuthController::class, 'loginAnnon']);
Route::post('/submit-food-in-game/{game}',[GameController::class, 'addFoodItem']);

Route::get('/startgame', [GameController::class, 'startGame']);


Route::get('/food', function(GameService $gameService){
    return $gameService->getRecentGameFoodItemsPerUser();
});


Route::get('/choiceleft', function(GameService $gameService){
    return $gameService->getUserActionLeftInGame(
        auth()->user()
    );
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
