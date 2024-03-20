<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('operator')->insert([
            'nama_operator' => 'operator1',
            'contact' => '081381021',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('operator')->insert([
            'nama_operator' => 'operator2',
            'contact' => '028321812',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
