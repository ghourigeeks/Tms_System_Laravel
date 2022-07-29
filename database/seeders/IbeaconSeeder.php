<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ibeacon;

class IbeaconSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Ibeacon::truncate();

        $ibeacons  = [
                array(
                    'client_id'  => '1',
                    'serial_no'  => '437843'
                ),
                array(
                    'client_id'  => '1',
                    'serial_no'  => '437843'
                ),
                array(
                    'client_id'  => '1',
                    'serial_no'  => '437843'
                ),
                array(
                    'client_id'  => '1',
                    'serial_no'  => '437843'
                ),
                array(
                    'client_id'  => '1',
                    'serial_no'  => '437843'
                )

           ];

           foreach ($ibeacons as $key => $ibeacon) {
            Ibeacon::create([
                    'client_id'    => $ibeacon['client_id'],
                    'serial_no'    => $ibeacon['serial_no'],
                ]);
            }
        }
    }