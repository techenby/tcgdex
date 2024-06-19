<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->foreignId('rarity_id');
            $table->foreignId('supertype_id');
            $table->foreignId('set_id');
            $table->string('name');
            $table->integer('hp');
            $table->string('types');
            $table->string('subtypes');
            $table->integer('converted_retreat_cost');
            $table->integer('number');
            $table->string('artist');
            $table->string('flavor_text');
            $table->string('national_pokedex_numbers')->nullable();
            $table->json('attacks');
            $table->string('evolves_from')->nullable();
            $table->json('evolves_to')->nullable();
            $table->json('legalities')->nullable();
            $table->json('images')->nullable();
            $table->json('retreat_cost')->nullable();
            $table->json('rules')->nullable();
            $table->json('weaknesses')->nullable();
            $table->json('resistances')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
