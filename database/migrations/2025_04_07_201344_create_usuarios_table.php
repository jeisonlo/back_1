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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('genero')->nullable();
            $table->string('codigo_recuperacion')->nullable();
            
            // Campos del perfil
            $table->string('vive_en')->nullable()->comment('Ciudad de residencia actual');
            $table->string('de_donde_es')->nullable()->comment('Ciudad de origen');
            $table->string('estudios')->nullable()->comment('Institución educativa');
            $table->text('acerca_de_mi')->nullable()->comment('Descripción personal');
            $table->string('foto')->nullable()->comment('URL de la foto en Cloudinary');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
