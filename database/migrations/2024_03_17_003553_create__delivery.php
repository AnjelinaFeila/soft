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
        Schema::create('delivery', function (Blueprint $table) {
            $table->increments('id_delivery');
            $table->string('no_surat_jalan')->nullable(false);
            $table->string('no_preorder')->nullable(false);
            $table->integer('id_material')->nullable(false);
            $table->decimal('kg_perpart');
            $table->integer('id_customer');
            $table->integer('jumlah_part');
            $table->date('tanggal_produksi');
            $table->date('tanggal_delivery');
            $table->string('qc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('delivery');
    }
};
