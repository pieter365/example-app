<?php

namespace Database\Factories;

use App\Models\ShoppingCartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartItemFactory extends Factory
{
    protected $model = ShoppingCartItem::class;

    public function definition()
    {
        return [
            'shopping_cart_id' => null, // This will be set by the ShoppingCartFactory
            'product_id' => null,       // This will be set by the ShoppingCartFactory
            'quantity' => rand(1, 3),
            'price' => 0,              // This will be set by the ShoppingCartFactory
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}