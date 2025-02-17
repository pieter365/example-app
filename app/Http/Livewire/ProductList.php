<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = ShoppingCartItem::where('shopping_cart_id', $cart->id)
                                    ->where('product_id', $productId)
                                    ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            ShoppingCartItem::create([
                'shopping_cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        session()->flash('message', 'Product added to cart successfully.');
        $this->emit('cartUpdated');
    }

    private function getOrCreateCart()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cart = ShoppingCart::firstOrCreate(['user_id' => $userId]);
        } else {
            $cartId = session()->get('cart_id');
            if (!$cartId) {
                $cart = ShoppingCart::create();
                session()->put('cart_id', $cart->id);
            } else {
                $cart = ShoppingCart::find($cartId);
            }
        }

        return $cart;
    }

    public function render()
    {
        return view('livewire.product-list');
    }
} 