<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Stock_rawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 2,
            'id_material' => 1,
            'jumlah_sheet'=> 500,
            'kg_persheet' => 5,
            'jumlah_nutt'=>13,
            'id_supplier'=>1,
            'id_customer'=>2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 5,
            'id_material' => 2,
            'jumlah_sheet'=> 800,
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>2,
            'id_customer'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 5,
            'id_material' => 3,
            'jumlah_sheet'=> 200,
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>2,
            'id_customer'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 5,
            'id_material' => 4,
            'jumlah_sheet'=> 100,
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>1,
            'id_customer'=>2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 5,
            'id_material' => 5,
            'jumlah_sheet'=> 300,
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>1,
            'id_customer'=>2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
         DB::table('stock_raw_material')->insert([
            'no_preorder' => 5,
            'id_material' => 6,
            'jumlah_sheet'=> 50,
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>1,
            'id_customer'=>2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
