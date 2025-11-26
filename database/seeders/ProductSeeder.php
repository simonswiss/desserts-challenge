<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the data from data.json
        $data = json_decode(file_get_contents(database_path('seeders/data.json')));

        foreach ($data as $item) {
            Product::create([
                'name' => $item->name,
                'category' => $item->category,
                'price_cents' => $item->price * 100,
                'image_path' => str_replace('./assets/images/', '', $item->image->mobile),
            ]);
        }
    }
}
