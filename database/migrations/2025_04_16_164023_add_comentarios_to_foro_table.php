<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('foros', function (Blueprint $table) {
            $table->json('comentarios')->nullable()->after('likes');
        });
    }

    public function down()
    {
        Schema::table('foros', function (Blueprint $table) {
            $table->dropColumn('comentarios');
        });
    }
};
