<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShoppingCartItem;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cartId = session()->get('cart_id');
        if (Auth::check()) {
            $userId = Auth::id();
            $cartId = ShoppingCart::where('user_id', $userId)->value('id');
        }

        $this->cartCount = ShoppingCartItem::where('shopping_cart_id', $cartId)->sum('quantity');
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
} 