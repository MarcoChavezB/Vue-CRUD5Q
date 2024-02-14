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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')
                ->min(3)
                ->max(50)
                ->notNullable();

            $table->string('apellido')
                ->min(3)
                ->max(50);

            $table->string('email')
                ->unique();

            $table->string('telefono')
                ->min(10)
                ->notNullable()
                ->unique();

            $table->string('direccion');
            
            $table->string('grado')
                ->enum('primero', 'segundo', 'tercero');

            $table->string('foto')->max(999);
            $table->boolean('is_disabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
