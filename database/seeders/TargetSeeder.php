<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('minimaltarget')->insert([
            'id_material' => 1,
            'id_proses' => 2,
            'minimal_target' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('minimaltarget')->insert([
            'id_material' => 2,
            'id_proses' => 1,
            'minimal_target' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('minimaltarget')->insert([
            'id_material' => 3,
            'id_proses' => 1,
            'minimal_target' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
