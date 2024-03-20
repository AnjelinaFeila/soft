<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('delivery')->insert([
            'id_material' => 1,
            'kg_perpart'=> 12,
            'id_customer'=>1,
            'jumlah_part'=>10,
            'tanggal_delivery'=>now(),
            'qc'=>'✔',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('delivery')->insert([
            'id_material' => 1,
            'kg_perpart'=> 7,
            'id_customer'=>2,
            'jumlah_part'=>20,
            'tanggal_delivery'=>now(),
            'qc'=>'✖',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
