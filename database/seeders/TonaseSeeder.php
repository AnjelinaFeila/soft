<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TonaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('tonase')->insert([
            'nama_tonase' => 'tonase1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tonase')->insert([
            'nama_tonase' => 'tonase2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
