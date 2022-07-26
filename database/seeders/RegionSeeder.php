<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Region;
  
class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::truncate();
  
        $regions = array(
           'Asia',
           'Europe',
           'Africa',
           'Oceania',
           'Americas',
           'Polar',
           ''
        );
          
        foreach ($regions as $key => $value) {
            Region::create(array("name" => $value));
        }
    }
}