<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    
    public function run()
    {
        $ratings = [
                        'Rating Message 1', 
                        'Rating Message 2', 
                        'Rating Message 3', 
                        'Rating Message 4', 
                        'Rating Message 5'
                    ];
      
        foreach ($ratings as $key => $rating) {
            Rating::create([
                                'name'  => $rating
                            ]);
        }
    }
}
