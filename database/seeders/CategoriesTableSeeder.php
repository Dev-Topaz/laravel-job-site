<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Category::create([
        'category_name' => 'Beauty',
        'text_color' => 'e10802',
        'back_color' => 'e1080233',
      ]);
      Category::create([
        'category_name' => 'Lifestyle',
        'text_color' => '7367d8',
        'back_color' => 'f0f0fd',
      ]);
      Category::create([
        'category_name' => 'Food',
        'text_color' => '6e4914',
        'back_color' => '6e491433',
      ]);
      Category::create([
        'category_name' => 'Entertainment',
        'text_color' => 'e57c00',
        'back_color' => 'e57c0033',
      ]);
      Category::create([
        'category_name' => 'Fitness',
        'text_color' => '6a31c0',
        'back_color' => '6a31c033',
      ]);
      Category::create([
        'category_name' => 'Travel',
        'text_color' => 'd0b811',
        'back_color' => 'f2ff2933',
      ]);
      Category::create([
        'category_name' => 'Tech',
        'text_color' => '3f484f',
        'back_color' => '3f484f33',
      ]);
      Category::create([
        'category_name' => 'Health',
        'text_color' => '297f28',
        'back_color' => '297f2833',
      ]);
      Category::create([
        'category_name' => 'Music',
        'text_color' => '6aef24',
        'back_color' => '6aef2433',
      ]);
      Category::create([
        'category_name' => 'Home',
        'text_color' => '3dfe24',
        'back_color' => '3dfe2433',
      ]);
    }
}
