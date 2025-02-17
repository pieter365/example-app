<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\ResponseService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a paginated listing of the products.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $perPage = $request->get('per_page', 10);
            $products = $this->productService->getAllProducts($perPage);
            return ResponseService::success(new ProductCollection($products));
        } catch (\Exception $e) {
            return ResponseService::error('Failed to retrieve products', 500);
        }
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->findProductById($id);
            if ($product) {
                return ResponseService::success(new ProductResource($product));
            }
            return ResponseService::error('Product not found', 404);
        } catch (ModelNotFoundException $e) {
            return ResponseService::error('Product not found', 404);
        } catch (\Exception $e) {
            return ResponseService::error('Failed to retrieve product', 500);
        }
    }

    /**
     * Store a newly created product in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->all());
            return ResponseService::success(new ProductResource($product), 'Product created successfully', 201);
        } catch (\Exception $e) {
            return ResponseService::error('Failed to create product', 500);
        }
    }

    /**
     * Update the specified product in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $product = $this->productService->updateProduct($id, $request->all());
            return ResponseService::success(new ProductResource($product), 'Product updated successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::error('Product not found', 404);
        } catch (\Exception $e) {
            return ResponseService::error('Failed to update product', 500);
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);
            return ResponseService::success(null, 'Product deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ResponseService::error('Product not found', 404);
        } catch (\Exception $e) {
            return ResponseService::error('Failed to delete product', 500);
        }
    }
}