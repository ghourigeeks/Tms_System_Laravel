<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    
    public function run()
    {
        $provinces = [
                        'Sindh', 
                        'Punjab', 
                        'KPK', 
                        'Baluchistan', 
                        'GB',
                        'AJK'
                    ];
      
        foreach ($provinces as $key => $province) {
            Province::create([
                                'name'  => $province
                            ]);
        }
    }
}
