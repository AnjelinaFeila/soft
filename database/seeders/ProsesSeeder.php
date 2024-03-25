<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('proses')->insert([
            'nama_proses' => 'blanking',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'bending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'bending2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'spot nut',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'piercing',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'spot assy',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'robot welding',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('proses')->insert([
            'nama_proses' => 'no proses',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
