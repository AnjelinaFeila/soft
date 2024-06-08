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
        Schema::table('riwayat_barang', function (Blueprint $table) {
            $table->string('jumlah_barang')->nullable(false); // Menambahkan kolom jumlah_barang dengan tipe data string
            $table->string('id_material')->change(); // Mengubah tipe data id_material menjadi string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_barang', function (Blueprint $table) {
            $table->dropColumn('jumlah_barang'); // Menghapus kolom jumlah_barang
            $table->integer('id_material')->change(); // Mengubah kembali tipe data id_material menjadi integer
        });
    }
};

