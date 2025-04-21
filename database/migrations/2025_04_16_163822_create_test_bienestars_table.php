<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('test_bienestars', function (Blueprint $table) {
            $table->id();

            $table->integer('peso');
            $table->integer('altura');
            $table->integer('edad');
            $table->set('sexo', ['Masculino', 'Femenino', 'Prefiero no decirlo'] );
            $table->set('complexion', ['Delgada', 'Promedio', 'Musculosa', 'Con sobrepeso'] );
            $table->set('actividad', ['Sedentario', 'Ligero', 'Moderado', 'Alto'] );
            $table->set('suenio', ['Menos de 5', '5-6', '7-8', 'Mas de 8'] );
            $table->set('estres', ['Bajo', 'Moderado', 'Alto', 'Muy alto'] );
            $table->set('objetivo', ['Perder peso', 'Mantener peso', 'Ganar peso', 'Mejorar habitos alimenticios', 'Mejorar mi salud en general'] );

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('test_bienestars');
    }
};

