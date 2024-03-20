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
        Schema::create('work_in_progress', function (Blueprint $table) {
            $table->increments('id_wip');
            $table->integer('id_material')->nullable(false);
            $table->decimal('kg_perpart');
            $table->integer('jumlah_part');
            $table->date('last_produksi');
            $table->integer('id_proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('work_in_progress');
    }
};
