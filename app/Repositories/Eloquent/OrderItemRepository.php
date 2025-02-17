<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    /**
     * Get all order items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return OrderItem::all();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve order items');
        }
    }

    /**
     * Find an order item by its ID.
     *
     * @param int $id
     * @return \App\Models\OrderItem
     * @throws Exception
     */
    public function find(int $id): \App\Models\OrderItem
    {
        try {
            return OrderItem::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order item not found');
        } catch (Exception $e) {
            throw new Exception('An error occurred');
        }
    }

    /**
     * Create a new order item.
     *
     * @param array $data
     * @return \App\Models\OrderItem
     * @throws Exception
     */
    public function create(array $data): \App\Models\OrderItem
    {
        try {
            return OrderItem::create($data);
        } catch (QueryException $e) {
            throw new Exception('Failed to create order item');
        }
    }

    /**
     * Update an existing order item.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\OrderItem
     * @throws Exception
     */
    public function update(int $id, array $data): \App\Models\OrderItem
    {
        try {
            $item = OrderItem::findOrFail($id);
            $item->update($data);
            return $item;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order item not found');
        } catch (QueryException $e) {
            throw new Exception('Failed to update order item');
        }
    }

    /**
     * Delete an order item by its ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $item = OrderItem::findOrFail($id);
            return $item->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order item not found');
        } catch (Exception $e) {
            throw new Exception('Failed to delete order item');
        }
    }

    /**
     * Get order items by order ID.
     *
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getByOrderId(int $orderId): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return OrderItem::where('order_id', $orderId)->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve items by order ID');
        }
    }
} 