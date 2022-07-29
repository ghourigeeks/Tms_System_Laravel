<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            RegionSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
            Sub_categorySeeder::class,
            FaqSeeder::class,
            ClientSeeder::class,
            ProductSeeder::class,
            Product_imageSeeder::class,
            BoxSeeder::class,
            IbeaconSeeder::class,
            ComplaintSeeder::class,
        ]);
    }
}
