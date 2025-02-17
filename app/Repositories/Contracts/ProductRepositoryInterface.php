<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a product by its ID.
     *
     * @param int $id
     * @return \App\Models\Product|null
     */
    public function find(int $id);

    /**
     * Create a new product.
     *
     * @param array $data
     * @return \App\Models\Product
     */
    public function create(array $data);

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * Delete a product by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get products by a specific criteria.
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCriteria(array $criteria);
} 