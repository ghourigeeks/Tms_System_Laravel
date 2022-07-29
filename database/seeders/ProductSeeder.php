<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Product::truncate();

        $products = [
                array(
                    'client_id'       => '1',
                    'name'            => 'Oppo a37',
                    'price'           => '70000',
                    'color'           => 'white',
                    'qty'             => '5',
                    'description'     => 'Source Oppo',
                    'category_id'     => '3',
                    'sub_category_id' => '3',
                    'qrcode'          => '45849767',
                    'barcode'         => 'Hyderabad',
                    'lat'             => '44.467',
                    'lng'             => '55.33'

                ),
                array(
                    'client_id'       => '1',
                    'name'            => 'Vivi v9',
                    'price'           => '70000',
                    'color'           => 'white',
                    'qty'             => '5',
                    'description'     => 'Source Vivo',
                    'category_id'     => '3',
                    'sub_category_id' => '3',
                    'qrcode'          => '45849767',
                    'barcode'         => 'Hyderabad',
                    'lat'             => '44.467',
                    'lng'             => '55.33'

                ),
                array(
                    'client_id'       => '1',
                    'name'            => 'Iphone X',
                    'price'           => '70000',
                    'color'           => 'white',
                    'qty'             => '5',
                    'description'     => 'Source Iphone',
                    'category_id'     => '3',
                    'sub_category_id' => '3',
                    'qrcode'          => '45849767',
                    'barcode'         => 'Hyderabad',
                    'lat'             => '44.467',
                    'lng'             => '55.33'

                ),
                array(
                    'client_id'       => '1',
                    'name'            => 'Infinix note7',
                    'price'           => '70000',
                    'color'           => 'white',
                    'qty'             => '5',
                    'description'     => 'Source Infinix',
                    'category_id'     => '3',
                    'sub_category_id' => '3',
                    'qrcode'          => '45849767',
                    'barcode'         => 'Hyderabad',
                    'lat'             => '44.467',
                    'lng'             => '55.33'

                ),
                array(
                    'client_id'       => '1',
                    'name'            => 'Realme c3',
                    'price'           => '70000',
                    'color'           => 'white',
                    'qty'             => '5',
                    'description'     => 'Source Realme',
                    'category_id'     => '3',
                    'sub_category_id' => '3',
                    'qrcode'          => '45849767',
                    'barcode'         => 'Hyderabad',
                    'lat'             => '44.467',
                    'lng'             => '55.33'

                )

           ];

           foreach ($products as $key => $product) {
            Product::create([
                    'client_id'        => $product['client_id'],
                    'name'             => $product['name'],
                    'price'            => $product['price'],
                    'color'            => $product['color'],
                    'qty'              => $product['qty'],
                    'description'      => $product['description'],
                    'category_id'      => $product['category_id'],
                    'sub_category_id'  => $product['sub_category_id'],
                    'qrcode'           => $product['qrcode'],
                    'barcode'          => $product['barcode'],
                    'lat'              => $product['lat'],
                    'lng'              => $product['lng'],

                ]);
            }
        }
    }