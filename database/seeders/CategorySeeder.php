<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Celana Abu-abu',
                'slug' => 'celana-abu-abu',
                'description' => 'Celana dengan warna abu-abu untuk seragam sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Rok Abu-abu',
                'slug' => 'rok-abu-abu',
                'description' => 'Rok dengan warna abu-abu untuk seragam sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Kemeja Putih',
                'slug' => 'kemeja-putih',
                'description' => 'Kemeja putih berkualitas untuk seragam sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Seragam Pramuka',
                'slug' => 'seragam-pramuka',
                'description' => 'Seragam pramuka dan perlengkapannya',
                'is_active' => true,
            ],
            [
                'name' => 'Batik Sekolah',
                'slug' => 'batik-sekolah',
                'description' => 'Baju batik khusus untuk seragam sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Almamater',
                'slug' => 'almamater',
                'description' => 'Almamater dan produk sekolah lainnya',
                'is_active' => true,
            ],
            [
                'name' => 'Baju Praktek',
                'slug' => 'baju-praktek',
                'description' => 'Baju praktek untuk kegiatan laboratorium dan prakter lainnya di sekolah',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}