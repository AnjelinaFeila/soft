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
            'ukuran'=> '12x10x11',
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
            'ukuran'=> '12x10x11',
            'kg_persheet' => 20,
            'jumlah_nutt'=>3,
            'id_supplier'=>2,
            'id_customer'=>1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
