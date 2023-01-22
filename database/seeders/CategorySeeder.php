<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            'category_name' => 'Men',
            'created_at' => Carbon::now(),
        ]);
        Category::insert([
            'category_name' => 'Women',
            'created_at' => Carbon::now(),
        ]);
        Category::insert([
            'category_name' => 'Child',
            'created_at' => Carbon::now(),
        ]);
    }
}
