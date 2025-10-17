<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_rounds', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('game_participant_id');
            $table->integer('game_round');

            $table->enum('power_used', [
                'steal',
                'defend',
                'swap'
            ]);

            $table->string('unique_key')->unique(); //should be game_round+game_id+game_participant_id then we can ensure db doesnt allow more then 1 selection per round per user.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_rounds');
    }
};
