<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Minuman', 'Makanan ringan', 'Kebutuhan pokok', 'Perawatan rumah'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
