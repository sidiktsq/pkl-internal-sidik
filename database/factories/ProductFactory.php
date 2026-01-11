<?php
// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // 1. Ambil kategori secara acak
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        // 2. Tentukan ukuran dan gender untuk variasi nama
        $size = fake()->randomElement(['S', 'M', 'L', 'XL', 'XXL']);
        $gender = fake()->randomElement(['Laki-laki', 'Perempuan']);
        
        // 3. Buat nama produk yang sinkron dengan nama kategori
        // Contoh: "Kemeja Putih - Ukuran L (Laki-laki)"
        $name = $category->name . " Ukuran " . $size . " (" . $gender . ")";
        
        $price = fake()->numberBetween(75000, 200000);

        return [
            'category_id' => $category->id,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => "Seragam " . strtolower($category->name) . " berkualitas tinggi. Bahan adem, tidak mudah kusut, dan jahitan rapi. Cocok untuk kebutuhan sekolah sehari-hari.",
            'price' => $price,
            'discount_price' => fake()->optional(0.2)->numberBetween(
                (int)($price * 0.8),
                (int)($price * 0.9)
            ),
            'stock' => fake()->numberBetween(5, 100),
            'weight' => fake()->numberBetween(250, 500),
            'is_active' => true,
            'is_featured' => fake()->boolean(10),
        ];
    }

    // State modifiers
    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    public function onSale(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];
            return [
                'discount_price' => (int)($price * fake()->randomFloat(2, 0.5, 0.8)),
            ];
        });
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }
}