<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            'Scheduled',
            'Waiting',
            'On the way',
            'Completed',
            'Cancelled'
		];
      
        foreach ($records as $record) {
            Status::create(['name' => $record]);
        }
    }
}
