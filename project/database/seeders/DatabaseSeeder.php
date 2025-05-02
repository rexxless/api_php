<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        # -- Users --
        User::factory()->create([
            'fio' => 'Admin',
            'email' => 'admin@shop.ru',
            'password' => bcrypt('QWEasd123'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'fio' => 'User',
            'email' => 'user@shop.ru',
            'password' => bcrypt('password'),
        ]);

        # -- Products --
        Product::factory()->create([
            'name' => 'Product name 1',
            'description' => 'Product description 1',
            'price' => 100,
        ]);

        Product::factory()->create([
            'name' => 'Product name 2',
            'description' => 'Product description 2',
            'price' => 200,
        ]);

        # -- Carts --
        Cart::factory()->create([
            'user_id' => 2,
            'products' => [1,1],
        ]);
    }
}
