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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('link');
            $table->text('descripcionlibro');
            $table->string('editorial');
            $table->string('autor');
            $table->string('pdf_url')->nullable(); // URL del PDF
            $table->string('portada_url')->nullable(); // Nueva columna para la URL de la portada

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('set null');

            
            $table->unsignedBigInteger('categorialibro_id')->nullable();
            $table->foreign('categorialibro_id')
            ->references('id')->on('categorialibros')
            ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
