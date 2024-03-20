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
        Schema::create('laporan_produksi', function (Blueprint $table) {
            $table->increments('id_laporan_produksi');
            $table->date('tanggal');
            $table->integer('id_material')->nullable(false);
            $table->integer('id_proses');
            $table->integer('id_tonase');
            $table->integer('jumlah_sheet');
            $table->integer('id_operator');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->time('jumlah_jam');
            $table->integer('jumlah_ok');
            $table->integer('jumlah_ng');
            $table->string('keterangan')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('laporan_produksi');
    }
};
