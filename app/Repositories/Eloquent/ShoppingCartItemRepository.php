<?php

namespace App\Repositories\Eloquent;

use App\Models\ShoppingCartItem;
use App\Repositories\Contracts\ShoppingCartItemRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class ShoppingCartItemRepository implements ShoppingCartItemRepositoryInterface
{
    /**
     * Get all shopping cart items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return ShoppingCartItem::all();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve shopping cart items');
        }
    }

    /**
     * Find a shopping cart item by its ID.
     *
     * @param int $id
     * @return \App\Models\ShoppingCartItem
     * @throws Exception
     */
    public function find(int $id): \App\Models\ShoppingCartItem
    {
        try {
            return ShoppingCartItem::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart item not found');
        } catch (Exception $e) {
            throw new Exception('An error occurred');
        }
    }

    /**
     * Create a new shopping cart item.
     *
     * @param array $data
     * @return \App\Models\ShoppingCartItem
     * @throws Exception
     */
    public function create(array $data): \App\Models\ShoppingCartItem
    {
        try {
            return ShoppingCartItem::create($data);
        } catch (QueryException $e) {
            throw new Exception('Failed to create shopping cart item');
        }
    }

    /**
     * Update an existing shopping cart item.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\ShoppingCartItem
     * @throws Exception
     */
    public function update(int $id, array $data): \App\Models\ShoppingCartItem
    {
        try {
            $item = ShoppingCartItem::findOrFail($id);
            $item->update($data);
            return $item;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart item not found');
        } catch (QueryException $e) {
            throw new Exception('Failed to update shopping cart item');
        }
    }

    /**
     * Delete a shopping cart item by its ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $item = ShoppingCartItem::findOrFail($id);
            return $item->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart item not found');
        } catch (Exception $e) {
            throw new Exception('Failed to delete shopping cart item');
        }
    }

    /**
     * Get shopping cart items by cart ID.
     *
     * @param int $cartId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getByCartId(int $cartId): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return ShoppingCartItem::where('shopping_cart_id', $cartId)->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve items by cart ID');
        }
    }

    /**
     * Get shopping cart items by user ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return ShoppingCartItem::whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve items by user ID');
        }
    }

    /**
     * Clear all items from a shopping cart.
     *
     * @param int $cartId
     * @return bool
     */
    public function clearCart(int $cartId): bool
    {
        return ShoppingCartItem::where('shopping_cart_id', $cartId)->delete();
    }

    /**
     * Get a shopping cart item by cart ID and product ID.
     *
     * @param int $cartId
     * @param int $productId
     * @return \App\Models\ShoppingCartItem|null
     */
    public function getByCartIdAndProductId(int $cartId, int $productId): ?\App\Models\ShoppingCartItem
    {
        return ShoppingCartItem::where('shopping_cart_id', $cartId)
                               ->where('product_id', $productId)
                               ->first();
    }
}