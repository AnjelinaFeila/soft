<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('material')->insert([
            'nama_barang' => 'build in 0001',
            'kg_persheet' => 1.26,
            'kg_perpart' => 5,
            'jumlah_persheet' => 10,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '1',
            'id_customer' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('material')->insert([
            'nama_barang' => 'build in 0002',
            'kg_persheet' => 2.13,
            'kg_perpart' => 7,
            'jumlah_persheet' => 20,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '2',
            'id_customer' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('material')->insert([
            'nama_barang' => 'build in 0003',
            'kg_persheet' => 2.13,
            'kg_perpart' => 7,
            'jumlah_persheet' => 30,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '2',
            'id_customer' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('material')->insert([
            'nama_barang' => 'build in 0004',
            'kg_persheet' => 2.13,
            'kg_perpart' => 7,
            'jumlah_persheet' => 30,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '2',
            'id_customer' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('material')->insert([
            'nama_barang' => 'build in 0005',
            'kg_persheet' => 3.13,
            'kg_perpart' => 10,
            'jumlah_persheet' => 20,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '2',
            'id_customer' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('material')->insert([
            'nama_barang' => 'build in 0006',
            'kg_persheet' => 4.13,
            'kg_perpart' => 15,
            'jumlah_persheet' => 40,
            'ukuran' => '1219X110X1.2',
            'id_supplier' => '2',
            'id_customer' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
