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
        Schema::create('material', function (Blueprint $table) {
            $table->increments('id_material');
            $table->string('nama_barang')->nullable(false);
            $table->decimal('kg_persheet')->nullable(false);
            $table->decimal('kg_perpart');
            $table->integer('jumlah_persheet');
            $table->string('ukuran');
            $table->integer('id_supplier')->nullable(false);
            $table->integer('id_customer')->nullable(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('material');
    }
};
