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
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tarea');
            $table->string('descripcion_tarea')->nullable();
            $table->enum('estado', ['tarea', 'en_progreso', 'completado'])->default('tarea');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            

            $table->unsignedBigInteger('mapadesueno_id')->nullable();
            $table->foreign('mapadesueno_id')
            ->references('id')->on('mapadesuenos')
            ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimientos');
    }
};
