<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $categories = \App\Models\Category::
        // \App\Models\Product::factory()->forCategory()->count(8)->create();
        \App\Models\Product::factory(40)->create();
    }
}
