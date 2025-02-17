<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find an order by its ID.
     *
     * @param int $id
     * @return \App\Models\Order|null
     */
    public function find(int $id);

    /**
     * Create a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     */
    public function create(array $data);

    /**
     * Update an existing order.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * Delete an order by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get orders by user ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId(int $userId);
} 