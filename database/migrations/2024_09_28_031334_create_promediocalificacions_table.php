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
        Schema::create('promediocalificacions', function (Blueprint $table) {
            $table->id();
            $table->double('promedioestrellas');
            $table->double('numerodecalificaciones');
            

            $table->unsignedBigInteger('libro_id')->nullable();
            $table->foreign('libro_id')
            ->references('id')->on('libros')
            ->onDelete('set null');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promediocalificacions');
    }
};
