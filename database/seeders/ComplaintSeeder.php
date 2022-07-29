<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint;

class ComplaintSeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Complaint::truncate();

        $complaints = [
                array(
                    'client_id'   => '1',
                    'subject'     => 'Incomplete or defective order',
                    'complaint'   => 'The sender’s address is usually put on top'
                ),
                array(
                    'client_id'   => '2',
                    'subject'     => 'Abnormal delay in sending the consignment',
                    'complaint'   => 'The sender’s address is followed by date'
                ),
                array(
                    'client_id'   => '3',
                    'subject'     => 'The goods arrive in a damaged condition',
                    'complaint'   => 'This is where you greet the person'
                ),
                array(
                    'client_id'   => '4',
                    'subject'     => 'The goods are different from what was ordered',
                    'complaint'   => 'This is the main content of the letter'
                ),
                array(
                    'client_id'   => '2',
                    'subject'     => 'Quantity of goods is not what was ordered',
                    'complaint'   => 'The tone of the content should be formal'
                )

           ];

           foreach ($complaints as $key => $complaint) {
            Complaint::create([
                    'client_id'  => $complaint['client_id'],
                    'subject'    => $complaint['subject'],
                    'complaint'  => $complaint['complaint'],    
                ]);
            }
        }
    }