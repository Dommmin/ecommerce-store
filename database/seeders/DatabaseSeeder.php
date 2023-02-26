<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Sold;
use App\Models\User;
use App\Models\Variant;
use Database\Factories\BrandFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(10)->create();


        ProductType::factory()->create(['key' => 'Kobiety', 'name' => 'Kobiece']);
        ProductType::factory()->create(['key' => 'Mężczyźni', 'name' => 'Męskie']);
        ProductType::factory()->create(['key' => 'Dzieci', 'name' => 'Dziecięce']);

        Brand::factory()->create(['name' => 'Adidas']);
        Brand::factory()->create(['name' => 'Nike']);
        Brand::factory()->create(['name' => 'Champion']);
        Brand::factory()->create(['name' => 'Emporio Armani']);
        Brand::factory()->create(['name' => 'Calvin Klein']);
        Brand::factory()->create(['name' => 'Tommy Jeans']);
        Brand::factory()->create(['name' => 'Levi\'s']);
        Brand::factory()->create(['name' => 'Diesel']);

        Category::factory(10)->create();
        Product::factory(100)->create();

        $colors = [];
        $images = [];

        for ($i = 1; $i <= 5; $i++) {
            $colors[] = Factory::create()->colorName();
            $images[] = Factory::create()->image('public/products', 640, 480, null, false);
        }

        Product::each(function ($product) use ($colors, $images) {
            foreach ($colors as $color) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color' => $color,
                    'image' => Arr::random($images),
                    'url' => Str::slug($product->name . '-' . $color),
                    'price' => Factory::create()->numberBetween(20, 1000),
                ]);
            }
        });

        ProductVariant::each(function ($variant) {
            $sizes = [30, 32, 34, 36, 38, 40];
            foreach ($sizes as $size) {
                ProductOption::create([
                    'product_variant_id' => $variant->id,
                    'size' => $size,
                    'price' => Factory::create()->boolean ? Factory::create()->numberBetween(20, 1000) : null,
                    'in_stock' => Factory::create()->numberBetween(0, 10),
                ]);
            }
        });

        Sold::factory(1000)->create();
    }
}
