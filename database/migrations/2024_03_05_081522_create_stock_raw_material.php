<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.a
     */
    public function up()
    {
        Schema::create('stock_raw_material', function (Blueprint $table) {
            $table->increments('id_stock_raw');
            $table->integer('no_preorder')->nullable(false);
            $table->integer('id_material')->nullable(false);
            $table->integer('jumlah_sheet');
            $table->string('ukuran');
            $table->decimal('kg_persheet');
            $table->integer('jumlah_nutt');
            $table->integer('id_supplier');
            $table->integer('id_customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('stock_raw_material');
    }
};
