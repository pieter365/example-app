<?php

namespace App\Services;

use App\Repositories\Contracts\ShoppingCartRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ShoppingCartItemRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartService
{
    protected $cartRepository;
    protected $productRepository;
    protected $cartItemRepository;

    public function __construct(
        ShoppingCartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        ShoppingCartItemRepositoryInterface $cartItemRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * Add a product to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function addToCart($productId, $quantity)
    {
        $userId = Auth::id();
        $cart = $this->cartRepository->getByUserId($userId);

        if (!$cart) {
            $cart = $this->cartRepository->create(['user_id' => $userId]);
        }

        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new Exception('Product not found');
        }

        $cartItem = $this->cartItemRepository->getByCartIdAndProductId($cart->id, $productId);

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $this->cartItemRepository->update($cartItem->id, ['quantity' => $cartItem->quantity]);
        } else {
            $this->cartItemRepository->create([
                'shopping_cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $cart;
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function updateCartItem($productId, $quantity)
    {
        $userId = Auth::id();
        $cart = $this->cartRepository->getByUserId($userId);

        if (!$cart) {
            throw new Exception('Cart not found');
        }

        $cartItem = $this->cartItemRepository->getByCartIdAndProductId($cart->id, $productId);

        if (!$cartItem) {
            throw new Exception('Product not in cart');
        }

        $this->cartItemRepository->update($cartItem->id, ['quantity' => $quantity]);

        return $cart;
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $productId
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function removeFromCart($productId)
    {
        $userId = Auth::id();
        $cart = $this->cartRepository->getByUserId($userId);

        if (!$cart) {
            throw new Exception('Cart not found');
        }

        $cartItem = $this->cartItemRepository->getByCartIdAndProductId($cart->id, $productId);

        if (!$cartItem) {
            throw new Exception('Product not in cart');
        }

        $this->cartItemRepository->delete($cartItem->id);

        return $cart;
    }

    /**
     * Get the current user's cart.
     *
     * @return \App\Models\ShoppingCart|null
     */
    public function getCart()
    {
        $userId = Auth::id();
        return $this->cartRepository->getByUserId($userId);
    }
} 