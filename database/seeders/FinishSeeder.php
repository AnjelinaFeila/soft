<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('finishgood')->insert([
            'nama_pegawai' => 'john doe',
            'id_material' => '1',
            'jumlah' => '10',
            'id_customer' => '1',
            'qc' => '✔',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('finishgood')->insert([
            'nama_pegawai' => 'jane doe',
            'id_material' => '2',
            'jumlah' => '20',
            'id_customer' => '2',
            'qc' => '✖',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
