<?php

namespace App\Repositories\Contracts;

interface OrderItemRepositoryInterface
{
    /**
     * Get all order items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find an order item by its ID.
     *
     * @param int $id
     * @return \App\Models\OrderItem|null
     */
    public function find(int $id);

    /**
     * Create a new order item.
     *
     * @param array $data
     * @return \App\Models\OrderItem
     */
    public function create(array $data);

    /**
     * Update an existing order item.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * Delete an order item by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get order items by order ID.
     *
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByOrderId(int $orderId);
} 