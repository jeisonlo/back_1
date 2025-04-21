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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('paciente_nombre');
            $table->integer('paciente_edad');
            $table->string('paciente_genero');
            $table->string('paciente_diagnostico');
            $table->text('tecnicas_pruebas_aplicadas');
            $table->text('observacion');
            $table->date('fecha');
            $table->string('evaluador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
