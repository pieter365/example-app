<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * ProductService class
 *
 * This class provides methods to interact with the product repository.
 */
class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get paginated products.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProducts(int $perPage = 20): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    /**
     * Find a product by its ID.
     *
     * @param int $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function findProductById(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
        return $product;
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param array $data
     * @return Product
     * @throws ModelNotFoundException
     */
    public function updateProduct(int $id, array $data): Product
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
        return $this->productRepository->update($id, $data);
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
        return $this->productRepository->delete($id);
    }
}