<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder

{
    public function run()
    {
        // for testing purpose data. delete it after live production

        Category::truncate();

        $categories = [
                array(
                    'name'       => 'Health & Medicine',
                    'created_by' => '1'
                ),
                array(
                    'name'       => 'Beauty & makeup',
                    'created_by' => '1'
                ),
                array(
                    'name'       => 'Headphones & Mobile',
                   'created_by'  => '1'
                ),
                array(
                    'name'       => 'Electronic item',
                    'created_by' => '1'
                ),
                array(
                    'name'       => 'Games & cd',
                    'created_by' => '1'
                )

           ];

           foreach ($categories as $key => $category) {
            Category::create([
                    'name'        => $category['name'],
                    'created_by'  => $category['created_by'],
                ]);
            }
        }
    }