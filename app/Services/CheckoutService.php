<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\ShoppingCartItemRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutService
{
    protected $orderRepository;
    protected $orderItemRepository;
    protected $cartItemRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        ShoppingCartItemRepositoryInterface $cartItemRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * Process the checkout for the current user.
     *
     * @return \App\Models\Order
     * @throws Exception
     */
    public function checkout()
    {
        $userId = Auth::id();
        $cartItems = $this->cartItemRepository->getByUserId($userId);

        if ($cartItems->isEmpty()) {
            throw new Exception('Cart is empty');
        }

        // Create an order
        $order = $this->orderRepository->create([
            'user_id' => $userId,
            'total_amount' => $cartItems->sum('price'),
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $this->orderItemRepository->create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
            ]);
        }

        // Clear the cart
        $this->cartItemRepository->clearCart($cartItems->first()->shopping_cart_id);

        return $order;
    }
}