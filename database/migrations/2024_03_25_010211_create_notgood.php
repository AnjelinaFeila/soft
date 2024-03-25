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
        Schema::create('notgood', function (Blueprint $table) {
            $table->increments('id_notgood');
            $table->integer('id_material')->nullable(false);
            $table->integer('jumlah_ng')->nullable(false);
            $table->string('keterangan')->nullable(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notgood');
    }
};
