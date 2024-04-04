<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WIPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('work_in_progress')->insert([
            'id_material' => 1,
            'kg_perpart' => 5,
            'jumlah_part'=>500,
            'last_produksi'=>now(),
            'id_proses'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('work_in_progress')->insert([
            'id_material' => 2,
            'kg_perpart' => 12,
            'jumlah_part'=>400,
            'last_produksi'=>now(),
            'id_proses'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('work_in_progress')->insert([
            'id_material' => 3,
            'kg_perpart' => 12,
            'jumlah_part'=>400,
            'last_produksi'=>now(),
            'id_proses'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
