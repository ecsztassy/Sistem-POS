<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        StoreSetting::firstOrCreate(['id' => 1], ['name' => 'Toko Ritel', 'address' => 'Jl. Melati No. 12, Jakarta', 'phone' => '021-555-0123', 'footer_note' => 'Terima kasih telah berbelanja. Sampai jumpa kembali!']);
        if (app()->environment(['local', 'testing'])) {
            $this->call([CategorySeeder::class, ItemSeeder::class]);
        }
    }
}
