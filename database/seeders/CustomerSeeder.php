<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('customer')->insert([
            'nama_customer' => 'jane doe',
            'alamat' => 'alamat customer 1 no 1 jalan 1',
            'contact' => '1112309981',
            'email' => 'customer1@customer.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customer')->insert([
            'nama_customer' => 'john',
            'alamat' => 'alamat customer 2 no 2 jalan 2',
            'contact' => '2222309981',
            'email' => 'customer2@customer.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
