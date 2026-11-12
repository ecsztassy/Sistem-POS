<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Minuman', 'Air Mineral 600ml', 3000, 4000, 48, 'botol'], ['Minuman', 'Teh Melati 350ml', 3500, 5000, 32, 'botol'],
            ['Minuman', 'Kopi Susu 250ml', 6000, 8500, 24, 'kotak'], ['Minuman', 'Susu UHT Cokelat', 5000, 6500, 18, 'kotak'],
            ['Makanan ringan', 'Keripik Kentang Original', 6500, 9000, 20, 'pack'], ['Makanan ringan', 'Biskuit Cokelat', 4500, 6000, 3, 'pack'],
            ['Makanan ringan', 'Wafer Vanila', 3000, 4500, 30, 'pack'], ['Makanan ringan', 'Roti Susu', 4000, 5500, 4, 'pcs'],
            ['Kebutuhan pokok', 'Beras Premium 5kg', 65000, 72000, 12, 'karung'], ['Kebutuhan pokok', 'Minyak Goreng 1L', 16000, 18500, 20, 'botol'],
            ['Kebutuhan pokok', 'Gula Pasir 1kg', 14000, 16500, 16, 'pack'], ['Kebutuhan pokok', 'Mi Instan Goreng', 2500, 3500, 60, 'pcs'],
            ['Perawatan rumah', 'Sabun Cuci Piring 750ml', 9500, 12000, 5, 'pouch'], ['Perawatan rumah', 'Tisu Wajah 250 Sheets', 8000, 11000, 22, 'pack'],
            ['Perawatan rumah', 'Detergen Bubuk 800g', 15000, 18500, 14, 'pack'], ['Perawatan rumah', 'Pembersih Lantai 800ml', 11000, 14000, 0, 'botol'],
        ];
        foreach ($rows as $index => [$category,$name,$buy,$sell,$stock,$unit]) {
            Item::firstOrCreate(['item_code' => 'BRG-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT)], ['category_id' => Category::where('name', $category)->firstOrFail()->id, 'name' => $name, 'buy_price' => $buy, 'sell_price' => $sell, 'stock' => $stock, 'unit' => $unit]);
        }
    }
}
