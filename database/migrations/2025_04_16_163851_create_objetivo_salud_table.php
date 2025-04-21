<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('objetivos_salud', function (Blueprint $table) {
            $table->id();

            $table->text('descripcion');
            $table->date('fecha_objetivo');
            $table->float('peso_actual');
            $table->float('meta_peso');
            $table->text('plan_dieta')->nullable();

            $table->timestamps();
        });
    }
};
