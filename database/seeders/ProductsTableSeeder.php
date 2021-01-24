<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['pro_1', 'pro_2'];

        foreach ($products as $product) {
            Product::create([
                'ar' => ['name' => $product, 'description' => 'des_ar'],
                'en' => ['name' => $product, 'description' => 'des_en'],
                'category_id' => 1,
                'purchase_price' => 15,
                'sale_price' => 15,
                'stock' => 10
            ]);
        }
    }
}
