<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\ResponseService;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Add a product to the cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
    
            // Ensure the user is authenticated
            $user = Auth::user();
            if (!$user) {
                return ResponseService::error('Unauthorized', 401);
            }
    
            $cart = $this->cartService->addToCart($productId, $quantity);
    
            return ResponseService::success(new CartResource($cart->load('items.product')), 'Product added to cart');
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('Error adding product to cart: ' . $e->getMessage());
            return ResponseService::error($e->getMessage(), 500);
        }
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCartItem(Request $request): JsonResponse
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');

            $cart = $this->cartService->updateCartItem($productId, $quantity);

            return ResponseService::success(new CartResource($cart->load('items.product')), 'Cart item updated');
        } catch (\Exception $e) {
            return ResponseService::error($e->getMessage());
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeFromCart(Request $request): JsonResponse
    {
        try {
            $productId = $request->input('product_id');

            $cart = $this->cartService->removeFromCart($productId);

            return ResponseService::success(new CartResource($cart->load('items.product')), 'Product removed from cart');
        } catch (\Exception $e) {
            return ResponseService::error($e->getMessage());
        }
    }

    /**
     * Get the current user's cart.
     *
     * @return JsonResponse
     */
    public function getCart(): JsonResponse
    {
        try {
            $cart = $this->cartService->getCart();

            if ($cart) {
                return ResponseService::success(new CartResource($cart->load('items.product')));
            }

            return ResponseService::error('Cart not found', 404);
        } catch (\Exception $e) {
            return ResponseService::error($e->getMessage(), 500);
        }
    }
}
