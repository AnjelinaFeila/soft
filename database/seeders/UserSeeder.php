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
            'id_pegawai' => '00000',
            'password' => Hash::make('00000'),
            'position' => 'owner',
            'phone' => '081123456789',
            'created_at' => now(),
            'updated_at' => now()
        ]);

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
            'name' => 'superadmin',
            'id_pegawai' => '22222',
            'password' => Hash::make('22222'),
            'position' => 'superadmin',
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

        DB::table('users')->insert([
            'name' => 'ppic',
            'id_pegawai' => '44444',
            'password' => Hash::make('44444'),
            'position' => 'ppic',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'supervisor',
            'id_pegawai' => '55555',
            'password' => Hash::make('55555'),
            'position' => 'supervisor',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'leader',
            'id_pegawai' => '66666',
            'password' => Hash::make('66666'),
            'position' => 'leader',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'processing',
            'id_pegawai' => '77777',
            'password' => Hash::make('77777'),
            'position' => 'processing',
            'phone' => '081123456000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
