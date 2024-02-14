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
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('creditos')->max(500);
            $table->string('duracion')->max(50);
            $table->boolean('certificada');
            $table->string('logo');
            $table->timestamps();
            $table->boolean('is_disabled')->default(false);

            $table->unsignedBigInteger('universidad_id');
            $table->foreign('universidad_id')->references('id')->on('universidades');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
