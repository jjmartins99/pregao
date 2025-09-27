<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Master',
            'email' => 'admin@pregao.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Loja Exemplo',
            'email' => 'vendor@pregao.test',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@pregao.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
