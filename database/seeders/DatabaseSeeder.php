<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Offer;
use App\Models\User;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Varient;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Offer::factory()->count(100)->create();
        Banner::factory()->count(5)->create();

       $collections = Collection::factory()->count(10)->create();

       foreach ($collections as $collection) {
           $products = Product::factory()->count(rand(50,200))->create([
               'collection_id' => $collection->id
           ]);

           foreach ($products as $product) {
               Varient::factory()->count(rand(4,6))->create([
                   'product_id' => $product->id
               ]);
           }
       }
    }
}
