<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sub_category;

class Sub_categorySeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Sub_category::truncate();

        $sub_categories  = [
                array(
                    'name'   => 'Zarbees Kids 1mg Melatonin Gummy',
                    'cat_id' => '1'
                ),
                array(
                    'name'   => 'Lash Princess False Lash Effect',
                    'cat_id' => '2'
                ),
                array(
                    'name'   => 'Apple AirPods (2nd Generation) Wireless Earbuds',
                   'cat_id'  => '3'
                ),
                array(
                    'name'   => 'Scotch Thermal Laminator, 2 Roller System',
                    'cat_id' => '4'
                ),
                array(
                    'name'   => 'Logitech G920 Driving Force Racing Wheel',
                    'cat_id' => '5'
                )

           ];

           foreach ($sub_categories as $key => $sub_category) {
            Sub_category::create([
                    'name'    => $sub_category['name'],
                    'cat_id'  => $sub_category['cat_id'],
                ]);
            }
        }
    }