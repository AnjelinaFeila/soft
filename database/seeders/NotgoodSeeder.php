<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotgoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('notgood')->insert([
            'id_material' => '1',
            'jumlah_ng' => '9',
            'keterangan' => 'production table has created successfuly without any problem 1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('notgood')->insert([
            'id_material' => '2',
            'jumlah_ng' => '53',
            'keterangan' => 'production table has created successfuly without any problem 2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('notgood')->insert([
            'id_material' => '3',
            'jumlah_ng' => '38',
            'keterangan' => 'production table has created successfuly without any problem 3',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
