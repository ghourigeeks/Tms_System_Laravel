<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use App\Models\Client;

class ClientSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Client::truncate();

        $clients = [
                array(
                    'fullname'       => 'Sam',
                    'username'       => 'sam123',
                    'email'          => 'sam@gmail.com',
                    'phone_no'       => '03341878311',
                    'password'       =>  Hash::make('rootroot'),
                    'address'        => 'Hyderabad Sindh',
                    'region_id'      => '1',
                    'country_id'     => '1',
                    'state'          => 'Sindh',
                    'city'           => 'Hyderabad',
                    'profile_pic'    => '331525526',
                    'verified'       => '1'

                ),
                array(
                    'fullname'       => 'Johny',
                    'username'       => 'johny123',
                    'email'          => 'johny@gmail.com',
                    'phone_no'       => '03341878312',
                    'password'       =>  Hash::make('rootroot'),
                    'address'        => 'Hyderabad Sindh',
                    'region_id'      => '1',
                    'country_id'     => '1',
                    'state'          => 'Sindh',
                    'city'           => 'Hyderabad',
                    'profile_pic'    => '331525526',
                    'verified'       => '1'

                ),
                array(
                    'fullname'       => 'talha',
                    'username'       => 'talha123',
                    'email'          => 'talha123@gmail.com',
                    'phone_no'       => '03341878313',
                    'password'       =>  Hash::make('rootroot'),
                    'address'        => 'Hyderabad Sindh',
                    'region_id'      => '1',
                    'country_id'     => '1',
                    'state'          => 'Sindh',
                    'city'           => 'Hyderabad',
                    'profile_pic'    => '331525526',
                    'verified'       => '1'

                ),
                array(
                    'fullname'       => 'Aquib',
                    'username'       => 'aquib123',
                    'email'          => 'aquib123@gmail.com',
                    'phone_no'       => '03341878314',
                    'password'       =>  Hash::make('rootroot'),
                    'address'        => 'Hyderabad Sindh',
                    'region_id'      => '1',
                    'country_id'     => '1',
                    'state'          => 'Sindh',
                    'city'           => 'Hyderabad',
                    'profile_pic'    => '331525526',
                    'verified'       => '1'

                ),

           ];

           foreach ($clients as $key => $client) {
            Client::create([
                    'fullname'    => $client['fullname'],
                    'username'    => $client['username'],
                    'email'       => $client['email'],
                    'phone_no'    => $client['phone_no'],
                    'password'    => $client['password'],
                    'address'     => $client['address'],
                    'region_id'   => $client['region_id'],
                    'country_id'  => $client['country_id'],
                    'state'       => $client['state'],
                    'city'        => $client['city'],
                    'profile_pic' => $client['profile_pic'],
                    'verified'    => $client['verified'],

                ]);
            }
        }
    }