<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            TargetSeeder::class,
            MaterialSeeder::class,
            Stock_rawSeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            TonaseSeeder::class,
            ProsesSeeder::class,
            DeliverySeeder::class,
            LaporanProduksiSeeder::class,
            OperatorSeeder::class,
            FinishSeeder::class,
            NotgoodSeeder::class,
            WIPSeeder::class
        ]);
    }
}
