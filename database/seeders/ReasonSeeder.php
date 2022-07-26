<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reason;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            'Reason 1',
            'Reason 2',
            'Reason 3',
            'Reason 4'
        ];
      
        foreach ($records as $record) {
            Reason::create(['name' => $record]);
        }
    }
}
