<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Software Development',
                'description' => 'Projects related to developing software applications or systems.',
            ],
            [
                'name' => 'Marketing Campaign',
                'description' => 'Projects focused on promoting products or services through marketing channels.',
            ],
            [
                'name' => 'Product Design',
                'description' => 'Projects involving the design and development of new products or improving existing ones.',
            ],
            [
                'name' => 'Research & Development',
                'description' => 'Projects dedicated to research and development activities for new technologies or products.',
            ],
            [
                'name' => 'Infrastructure',
                'description' => 'Projects related to building or maintaining physical or digital infrastructure.',
            ],
        ];

        // Insert categories into the categories table
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_by' => '1',
            ]);
        }
    }
}
