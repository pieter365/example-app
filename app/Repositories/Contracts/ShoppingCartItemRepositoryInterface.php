<?php

namespace App\Repositories\Contracts;

interface ShoppingCartItemRepositoryInterface
{
    /**
     * Get all shopping cart items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a shopping cart item by its ID.
     *
     * @param int $id
     * @return \App\Models\ShoppingCartItem|null
     */
    public function find(int $id);

    /**
     * Create a new shopping cart item.
     *
     * @param array $data
     * @return \App\Models\ShoppingCartItem
     */
    public function create(array $data);

    /**
     * Update an existing shopping cart item.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * Delete a shopping cart item by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get shopping cart items by cart ID.
     *
     * @param int $cartId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCartId(int $cartId);

    /**
     * Get shopping cart items by user ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId(int $userId);

    /**
     * Clear all items from a shopping cart.
     *
     * @param int $cartId
     * @return bool
     */
    public function clearCart(int $cartId);
} 