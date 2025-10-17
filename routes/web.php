<?php

use App\Events\GameStarted;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/testevent', function(){
    GameStarted::dispatch('hello');

    return 1;
});

Route::get('/listen', function (){
    return Inertia::render('listen',[]);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
