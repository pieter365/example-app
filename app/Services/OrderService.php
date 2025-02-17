<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Retrieve orders for a specific user by their user ID.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getOrdersByUserId($userId)
    {
        return $this->orderRepository->getByUserId($userId);
    }
}