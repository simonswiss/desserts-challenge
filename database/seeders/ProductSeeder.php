<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(File::get(database_path('seeders/data.json')));

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
