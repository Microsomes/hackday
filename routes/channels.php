<?php

use App\Broadcasting\WaitingRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('waiting-room', function (){
    return true;
});


Broadcast::channel('waiting-room2', WaitingRoom::class);
