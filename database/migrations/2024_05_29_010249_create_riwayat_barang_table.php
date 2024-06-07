<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_barang', function (Blueprint $table) {
            $table->increments('id_riwayat');
            $table->integer('id_supplier')->nullable(false);
            $table->string('nomor')->nullable(false);
            $table->string('nomor_so')->nullable(true);
            $table->date('tanggal_terima')->nullable(false);
            $table->string('nomor_preorder')->nullable(false);
            $table->string('kode_part')->nullable(true);
            $table->string('id_material')->nullable(false);
            $table->string('jumlah_barang')->nullable(false);
            $table->string('part_number')->nullable(true);
            $table->integer('jumlah_part')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_barang');
    }
};
