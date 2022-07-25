<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('opponent_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('grid')->default(3)->comment('3x3, 4x4, 5x5');
            $table->boolean('game_finished')->default(false);
            $table->boolean('creator_win')->default(false);
            $table->dateTime('schedulet_at')->nullable();
            $table->json('state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
