<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            return;
        }
        foreach ([['Administrator', 'admin'], ['Kasir Toko', 'kasir']] as [$name, $role]) {
            User::firstOrCreate(['username' => $role], ['name' => $name, 'role' => $role, 'password' => 'Password123!']);
        }
    }
}
