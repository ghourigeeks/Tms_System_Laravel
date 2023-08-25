<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run()
    {

        Category::truncate();

        $categories  = [
                array(
                    'name'    => 'Wordmarks/logotypes',
                ),
                array(
                    'name'    => 'Letterforms',
                ),
                array(
                    'name'    => 'Lettermarks/monogram logos',
                ),
                array(
                    'name'    => 'Logo symbols/brandmarks/pictorialmarks',
                ),
                array(
                    'name'    => 'Mascots',
                ),
                array(
                    'name'    => 'Emblems',
                ),
                array(
                    'name'    => 'Combination marks',
                ),
                array(
                    'name'    => 'Dynamic Marks',
                )

           ];

           foreach ($categories as $key => $category) {
            Category::create([
                    'name'     => $category['name'],
                ]);
            }
        }
    }