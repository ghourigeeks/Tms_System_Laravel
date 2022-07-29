<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product_image;

class Product_imageSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Product_image::truncate();

        $products_images = [
                array(
                    'product_id'     => '1',
                    'pic'            => 'oppo'

                ),
                array(
                    'product_id'     => '2',
                    'pic'            => 'vivo'

                ),
                array(
                    'product_id'     => '3',
                    'pic'            => 'iphone'

                ),
                array(
                    'product_id'     => '4',
                    'pic'            => 'infinix'

                ),
                array(
                    'product_id'     => '5',
                    'pic'            => 'realme'

                )

           ];

           foreach ($products_images as $key => $products_image) {
            Product_image::create([
                    'product_id'        => $products_image['product_id'],
                    'pic'               => $products_image['pic'],
                ]);
            }
        }
    }