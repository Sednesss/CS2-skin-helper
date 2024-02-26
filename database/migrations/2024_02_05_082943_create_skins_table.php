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
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_item_id');
            $table->foreign('game_item_id')->references('id')->on('game_items')->onDelete('cascade');
            $table->string('description')->nullable(true);
            $table->integer('pattern')->unsigned();
            $table->float('float', 21, 20)->unsigned()->nullable(true)->default(0);
            $table->timestamps();

            $table->unique(['game_item_id', 'pattern']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skins');
    }
};
