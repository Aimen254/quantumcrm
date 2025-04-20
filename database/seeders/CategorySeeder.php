<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'New Theme Release', 'color' => 'primary'],
            ['name' => 'My Event', 'color' => 'warning'],
            ['name' => 'Meet Manager', 'color' => 'danger'],
            ['name' => 'Create New Theme', 'color' => 'info'],
            ['name' => 'Product feedback', 'color' => 'dark'],
            ['name' => 'Meeting', 'color' => 'secondary'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category['name'],
            ], [
                'color' => $category['color'],
            ]);
        }
    }
}
