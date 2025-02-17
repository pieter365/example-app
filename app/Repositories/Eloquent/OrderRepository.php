<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return Order::all();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve orders');
        }
    }

    /**
     * Find an order by its ID.
     *
     * @param int $id
     * @return \App\Models\Order
     * @throws Exception
     */
    public function find(int $id): \App\Models\Order
    {
        try {
            return Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order not found');
        } catch (Exception $e) {
            throw new Exception('An error occurred');
        }
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     * @throws Exception
     */
    public function create(array $data): \App\Models\Order
    {
        try {
            return Order::create($data);
        } catch (QueryException $e) {
            throw new Exception('Failed to create order');
        }
    }

    /**
     * Update an existing order.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Order
     * @throws Exception
     */
    public function update(int $id, array $data): \App\Models\Order
    {
        try {
            $order = Order::findOrFail($id);
            $order->update($data);
            return $order;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order not found');
        } catch (QueryException $e) {
            throw new Exception('Failed to update order');
        }
    }

    /**
     * Delete an order by its ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $order = Order::findOrFail($id);
            return $order->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Order not found');
        } catch (Exception $e) {
            throw new Exception('Failed to delete order');
        }
    }

    /**
     * Get orders by user ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return Order::where('user_id', $userId)->with('items.product')->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve orders by user ID');
        }
    }
} 