<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->index();
            $table->string('name');
            $table->string('series');
            $table->integer('printed_total');
            $table->integer('total');
            $table->json('legalities');
            $table->string('ptcgo_code')->nullable();
            $table->date('release_date');
            $table->json('images');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
