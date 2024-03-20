<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'owner',
            'id_pegawai' => '11111',
            'password' => Hash::make('11111'),
            'position' => 'owner',
            'phone' => '081123456789',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'id_pegawai' => '22222',
            'password' => Hash::make('22222'),
            'position' => 'user',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'id_pegawai' => '33333',
            'password' => Hash::make('33333'),
            'position' => 'admin',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
