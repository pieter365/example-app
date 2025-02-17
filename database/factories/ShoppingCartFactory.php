<?php

namespace Database\Factories;

use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShoppingCartFactory extends Factory
{
    protected $model = ShoppingCart::class;

    public function definition()
    {
        // Get 5 random existing products
        $products = Product::inRandomOrder()->take(5)->get();
        
        // Calculate initial values
        $quantities = [];
        $totalItems = 0;
        $totalAmount = 0;

        // Generate random quantities and calculate totals
        foreach ($products as $product) {
            $quantity = rand(1, 3);
            $quantities[$product->id] = $quantity;
            $totalItems += $quantity;
            $totalAmount += $product->price * $quantity;
        }

        return [
            'user_id' => \App\Models\User::factory(),
            'session_id' => Str::uuid(),
            'total_items' => $totalItems,
            'total_amount' => $totalAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ShoppingCart $cart) {
            // Get the same 5 random products
            $products = Product::inRandomOrder()->take(5)->get();
            
            foreach ($products as $product) {
                ShoppingCartItem::factory()->create([
                    'shopping_cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }

            // Calculate totals directly from the database
            $cartItems = ShoppingCartItem::where('shopping_cart_id', $cart->id)->get();
            
            $totalItems = $cartItems->sum('quantity');
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            // Update the cart with final totals
            $cart->update([
                'total_items' => $totalItems,
                'total_amount' => $totalAmount,
            ]);
        });
    }
}