<?php

namespace App\Repositories\Eloquent;

use App\Models\ShoppingCart;
use App\Repositories\Contracts\ShoppingCartRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class ShoppingCartRepository implements ShoppingCartRepositoryInterface
{
    /**
     * Get all shopping carts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return ShoppingCart::all();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve shopping carts');
        }
    }

    /**
     * Find a shopping cart by its ID.
     *
     * @param int $id
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function find(int $id): \App\Models\ShoppingCart
    {
        try {
            return ShoppingCart::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart not found');
        } catch (Exception $e) {
            throw new Exception('An error occurred');
        }
    }

    /**
     * Create a new shopping cart.
     *
     * @param array $data
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function create(array $data): \App\Models\ShoppingCart
    {
        try {
            return ShoppingCart::create($data);
        } catch (QueryException $e) {
            throw new Exception('Failed to create shopping cart');
        }
    }

    /**
     * Update an existing shopping cart.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\ShoppingCart
     * @throws Exception
     */
    public function update(int $id, array $data): \App\Models\ShoppingCart
    {
        try {
            $cart = ShoppingCart::findOrFail($id);
            $cart->update($data);
            return $cart;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart not found');
        } catch (QueryException $e) {
            throw new Exception('Failed to update shopping cart');
        }
    }

    /**
     * Delete a shopping cart by its ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $cart = ShoppingCart::findOrFail($id);
            return $cart->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Shopping cart not found');
        } catch (Exception $e) {
            throw new Exception('Failed to delete shopping cart');
        }
    }

    /**
     * Get a shopping cart by user ID.
     *
     * @param int $userId
     * @return \App\Models\ShoppingCart|null
     * @throws Exception
     */
    public function getByUserId(int $userId): ?\App\Models\ShoppingCart
    {
        try {
            return ShoppingCart::where('user_id', $userId)->first();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve shopping cart by user ID');
        }
    }

    /**
     * Get a shopping cart by session ID.
     *
     * @param string $sessionId
     * @return \App\Models\ShoppingCart|null
     * @throws Exception
     */
    public function getBySessionId(string $sessionId): ?\App\Models\ShoppingCart
    {
        try {
            return ShoppingCart::where('session_id', $sessionId)->first();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve shopping cart by session ID');
        }
    }
}
