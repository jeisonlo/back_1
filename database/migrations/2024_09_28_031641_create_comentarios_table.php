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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('comentario');
            $table->date('fechacreacion');
            
            




            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('set null');

            
            $table->unsignedBigInteger('libro_id')->nullable();
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['libro_id']);
            $table->dropColumn('libro_id');
        });
    }
};
