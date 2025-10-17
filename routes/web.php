<?php

use App\Events\GameStarted;
use App\Http\Controllers\GameController;
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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
