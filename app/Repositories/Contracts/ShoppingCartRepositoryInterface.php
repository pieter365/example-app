<?php

namespace App\Repositories\Contracts;

interface ShoppingCartRepositoryInterface
{
    /**
     * Get all shopping carts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a shopping cart by its ID.
     *
     * @param int $id
     * @return \App\Models\ShoppingCart|null
     */
    public function find(int $id);

    /**
     * Create a new shopping cart.
     *
     * @param array $data
     * @return \App\Models\ShoppingCart
     */
    public function create(array $data);

    /**
     * Update an existing shopping cart.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * Delete a shopping cart by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get a shopping cart by user ID.
     *
     * @param int $userId
     * @return \App\Models\ShoppingCart|null
     */
    public function getByUserId(int $userId);
} 