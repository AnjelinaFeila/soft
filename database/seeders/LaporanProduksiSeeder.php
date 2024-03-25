<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('laporan_produksi')->insert([
            'tanggal'=>now(),
            'id_material'=>1,
            'id_proses'=>2,
            'id_tonase'=>1,
            'jumlah_sheet'=>10,
            'id_operator'=>1,
            'jam_mulai'=>now(),
            'jam_selesai'=>now(),
            'jumlah_jam'=>now(),
            'jumlah_ok'=>10,
            'jumlah_ng'=>9,
            'keterangan'=>'production table has created successfuly without any problem 1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('laporan_produksi')->insert([
            'tanggal'=>now(),
            'id_material'=>2,
            'id_proses'=>1,
            'id_tonase'=>2,
            'jumlah_sheet'=>10,
            'id_operator'=>1,
            'jam_mulai'=>now(),
            'jam_selesai'=>now(),
            'jumlah_jam'=>now(),
            'jumlah_ok'=>17,
            'jumlah_ng'=>33,
            'keterangan'=>'production table has created successfuly without any problem 2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('laporan_produksi')->insert([
            'tanggal'=>now(),
            'id_material'=>2,
            'id_proses'=>1,
            'id_tonase'=>2,
            'jumlah_sheet'=>10,
            'id_operator'=>1,
            'jam_mulai'=>now(),
            'jam_selesai'=>now(),
            'jumlah_jam'=>now(),
            'jumlah_ok'=>30,
            'jumlah_ng'=>20,
            'keterangan'=>'production table has created successfuly without any problem 3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('laporan_produksi')->insert([
            'tanggal'=>now(),
            'id_material'=>3,
            'id_proses'=>1,
            'id_tonase'=>2,
            'jumlah_sheet'=>10,
            'id_operator'=>2,
            'jam_mulai'=>now(),
            'jam_selesai'=>now(),
            'jumlah_jam'=>now(),
            'jumlah_ok'=>15,
            'jumlah_ng'=>23,
            'keterangan'=>'production table has created successfuly without any problem 4',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('laporan_produksi')->insert([
            'tanggal'=>now(),
            'id_material'=>3,
            'id_proses'=>1,
            'id_tonase'=>2,
            'jumlah_sheet'=>10,
            'id_operator'=>2,
            'jam_mulai'=>now(),
            'jam_selesai'=>now(),
            'jumlah_jam'=>now(),
            'jumlah_ok'=>21,
            'jumlah_ng'=>15,
            'keterangan'=>'production table has created successfuly without any problem 5',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
