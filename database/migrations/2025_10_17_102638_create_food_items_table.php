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
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('game_participant_id'); //links to a user of game

            $table->string('food_name');
           
            $table->enum('type',[
                'drink',
                'side',
                'main'
            ]);

            $table->string('unique_key')->unique(); // game_id+game_participant_id+type so we can ensure only 1 drink 1 side and 1 main per user.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
