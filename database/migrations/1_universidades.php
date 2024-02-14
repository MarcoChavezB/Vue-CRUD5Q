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
        Schema::create('universidades', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('web');
            $table->string('logo');
            $table->string('estado')-> enum('activo', 'inactivo') -> default('activo');
            $table->boolean('is_disabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universidades');
    }
};
