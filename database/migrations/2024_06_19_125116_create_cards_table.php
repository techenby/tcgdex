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
            $table->string('external_id');
            $table->string('name');
            $table->string('supertype');
            $table->string('level')->nullable();
            $table->string('hp')->nullable();
            $table->string('evolves_from')->nullable();
            $table->integer('converted_retreat_cost')->nullable();
            $table->string('number');
            $table->string('artist')->nullable();
            $table->string('rarity')->nullable();
            $table->string('flavor_text')->nullable();
            $table->string('regulation_mark')->nullable();
            $table->json('subtypes')->nullable();
            $table->json('types')->nullable();
            $table->json('evolves_to')->nullable();
            $table->json('rules')->nullable();
            $table->json('retreat_cost')->nullable();
            $table->string('set_id');
            $table->json('ancient_trait')->nullable();
            $table->json('abilities')->nullable();
            $table->json('attacks')->nullable();
            $table->json('weaknesses')->nullable();
            $table->json('resistances')->nullable();
            $table->json('national_pokedex_numbers')->nullable();
            $table->json('legalities');
            $table->json('images');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
