<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return Product::all();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve products');
        }
    }

    /**
     * Find a product by its ID.
     *
     * @param int $id
     * @return \App\Models\Product
     * @throws Exception
     */
    public function find(int $id): \App\Models\Product
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Product not found');
        } catch (Exception $e) {
            throw new Exception('An error occurred');
        }
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return \App\Models\Product
     * @throws Exception
     */
    public function create(array $data): \App\Models\Product
    {
        try {
            return Product::create($data);
        } catch (QueryException $e) {
            throw new Exception('Failed to create product');
        }
    }

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Product
     * @throws Exception
     */
    public function update(int $id, array $data): \App\Models\Product
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($data);
            return $product;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Product not found');
        } catch (QueryException $e) {
            throw new Exception('Failed to update product');
        }
    }

    /**
     * Delete a product by its ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $product = Product::findOrFail($id);
            return $product->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Product not found');
        } catch (Exception $e) {
            throw new Exception('Failed to delete product');
        }
    }

    /**
     * Search products by name.
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByName(string $name)
    {
        try {
            return Product::where('name', 'like', '%' . $name . '%')->get();
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to search products'], 500);
        }
    }

    /**
     * Paginate products.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 20)
    {
        try {
            return Product::paginate($perPage);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to retrieve products'], 500);
        }
    }

    /**
     * Get products by a specific criteria.
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getByCriteria(array $criteria): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return Product::where($criteria)->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to retrieve products by criteria');
        }
    }
} 