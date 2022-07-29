<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Box;

class BoxSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Box::truncate();

        $boxs  = [
                array(
                    'client_id'   => '1',
                    'name'        => 'box1',
                    'price'       => '3000',
                    'description' => 'source box1',
                    'qrcode'      => '4637686',
                    'barcode'     => 'barcode1'
                ),
                array(
                    'client_id'   => '1',
                    'name'        => 'box2',
                    'price'       => '3000',
                    'description' => 'source box2',
                    'qrcode'      => '4637686',
                    'barcode'     => 'barcode2'
                ),
                array(
                    'client_id'   => '1',
                    'name'        => 'box3',
                    'price'       => '3000',
                    'description' => 'source box3',
                    'qrcode'      => '4637686',
                    'barcode'     => 'barcode3'
                ),
                array(
                    'client_id'   => '1',
                    'name'        => 'box4',
                    'price'       => '3000',
                    'description' => 'source box4',
                    'qrcode'      => '4637686',
                    'barcode'     => 'barcode4'
                ),
                array(
                    'client_id'   => '1',
                    'name'        => 'box5',
                    'price'       => '3000',
                    'description' => 'source box5',
                    'qrcode'      => '4637686',
                    'barcode'     => 'barcode5'
                ),

           ];

           foreach ($boxs as $key => $box) {
            Box::create([
                    'client_id'     => $box['client_id'],
                    'name'          => $box['name'],
                    'price'         => $box['price'],
                    'description'   => $box['description'],
                    'qrcode'        => $box['qrcode'],
                    'barcode'       => $box['barcode'],
                ]);
            }
        }
    }