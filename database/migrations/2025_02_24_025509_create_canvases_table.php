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
        Schema::create('canvases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cloudinary_id')->nullable();
            $table->string('cloudinary_url')->nullable();
            $table->text('canvas_data')->nullable(); // Para guardar el JSON del canvas
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvases');
    }
};
