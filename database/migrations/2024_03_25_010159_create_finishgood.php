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
        Schema::create('finishgood', function (Blueprint $table) {
            $table->increments('id_finishgood');
            $table->string('nama_pegawai');
            $table->integer('id_material')->nullable(false);
            $table->integer('jumlah')->nullable(false);
            $table->integer('id_customer');
            $table->string('qc');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('finishgood');
    }
};
