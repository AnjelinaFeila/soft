<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('supplier')->insert([
            'nama_supplier' => 'supplier1',
            'alamat' => 'alamat supplier 1 no 1 jalan 1',
            'contact' => '1112309981',
            'email' => 'supplier1@supplier.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('supplier')->insert([
            'nama_supplier' => 'supplier2',
            'alamat' => 'alamat supplier 2 no 2 jalan 2',
            'contact' => '2222309981',
            'email' => 'supplier2@supplier.com',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
