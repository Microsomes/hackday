<?php

use App\Events\WaitingForUserEvent;
use App\Service\GameService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::call(function () {
    try{

        $game = app(GameService::class)->getRecentGame();
        $users = app(GameService::class)->checkWaitingOn($game);

        Log::debug($users);

        WaitingForUserEvent::dispatch($users);

            
    }catch(Exception $e){}
})->everyFiveSeconds();