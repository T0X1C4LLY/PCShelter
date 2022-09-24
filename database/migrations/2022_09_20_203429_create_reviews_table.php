<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignUuid('game_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('music');
            $table->unsignedInteger('graphic');
            $table->unsignedInteger('atmosphere');
            $table->unsignedInteger('difficulty');
            $table->unsignedInteger('storyline');
            $table->unsignedInteger('relaxation');
            $table->unsignedInteger('pleasure');
            $table->unsignedInteger('child-friendly');
            $table->unsignedInteger('NSFW');
            $table->unsignedInteger('gore');
            $table->unsignedInteger('unique');
            $table->unsignedInteger('general');
            $table->unsignedInteger('current_time_played');
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
        Schema::dropIfExists('reviews');
    }
};
