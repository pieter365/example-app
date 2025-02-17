<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;

class ShoppingCartSeeder extends Seeder
{
    public function run()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a shopping cart for the user
        $cart = ShoppingCart::factory()->create(['user_id' => $user->id]);

        // Add products to the shopping cart
        $products = Product::factory(5)->create();

        foreach ($products as $product) {
            ShoppingCartItem::factory()->create([
                'shopping_cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
            ]);
        }
    }
} 