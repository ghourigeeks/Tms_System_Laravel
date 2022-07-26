<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint_tag;

class Complaint_tagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            'Complaint 1',
            'Complaint 2',
            'Complaint 3',
            'Complaint 4'
         ];
      
        foreach ($records as $record) {
            Complaint_tag::create(['name' => $record]);
        }
    }
}
