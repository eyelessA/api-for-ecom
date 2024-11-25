<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $products = [
            'Колбаса' => ['price' => 100, 'quantity' => 20],
            'Сыр' => ['price' => 200, 'quantity' => 30],
            'Хлеб' => ['price' => 300, 'quantity' => 40],
        ];

        foreach ($products as $key => $product) {
            Product::create([
                'name' => $key,
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        $paymentMethods = ['ya.ru', 'tinkoff.com', 'sberbank.ru'];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create([
                'name' => $method,
            ]);
        }
    }
}
