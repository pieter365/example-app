<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = Mockery::mock(ProductService::class);
        $this->app->instance(ProductService::class, $this->productService);
    }

    /** @test */
    public function it_can_list_products_with_pagination()
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(3)->make();

        // Create a LengthAwarePaginator instance
        $paginator = new LengthAwarePaginator(
            $products, // Items
            3, // Total items
            10, // Items per page
            1, // Current page
            ['path' => '/api/v1/products'] // Ensure the path is set
        );

        $this->productService
            ->shouldReceive('getAllProducts')
            ->with(10)
            ->once()
            ->andReturn($paginator);

        $response = $this->actingAs($user)->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'price'
                        ]
                    ],
                    'meta' => [
                        'total',
                        'count',
                        'per_page',
                        'current_page',
                        'total_pages'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_pagination_parameters()
    {
        $user = User::factory()->create();

        // Mock the ProductService to ensure it doesn't interfere with validation
        $this->productService
            ->shouldReceive('getAllProducts')
            ->never(); // Ensure this method is not called

        $response = $this->actingAs($user)->getJson('/api/v1/products?per_page=invalid');

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'errors' => [
                    'per_page'
                ]
            ]);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->productService
            ->shouldReceive('findProductById')
            ->with($product->id)
            ->once()
            ->andReturn($product);

        $response = $this->actingAs($user)->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_when_product_not_found()
    {
        $user = User::factory()->create();

        $this->productService
            ->shouldReceive('findProductById')
            ->with(999)
            ->once()
            ->andThrow(new ModelNotFoundException);

        $response = $this->actingAs($user)->getJson('/api/v1/products/999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $user = User::factory()->create();
        $productData = [
            'name' => 'New Product',
            'description' => 'Product Description',
            'price' => 99.99
        ];

        $createdProduct = Product::factory()->make($productData);

        $this->productService
            ->shouldReceive('createProduct')
            ->with($productData)
            ->once()
            ->andReturn($createdProduct);

        $response = $this->actingAs($user)->postJson('/api/v1/products', $productData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price'
                ]
            ]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $productData = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 149.99
        ];

        $updatedProduct = Product::factory()->make($productData);

        $this->productService
            ->shouldReceive('updateProduct')
            ->with($product->id, $productData)
            ->once()
            ->andReturn($updatedProduct);

        $response = $this->actingAs($user)->putJson("/api/v1/products/{$product->id}", $productData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_when_updating_non_existent_product()
    {
        $user = User::factory()->create();

        $this->productService
            ->shouldReceive('updateProduct')
            ->with(999, [])
            ->once()
            ->andThrow(new ModelNotFoundException);

        $response = $this->actingAs($user)->putJson('/api/v1/products/999', []);

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->productService
            ->shouldReceive('deleteProduct')
            ->with($product->id)
            ->once()
            ->andReturn(true);

        $response = $this->actingAs($user)->deleteJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);
    }

    /** @test */
    public function it_returns_404_when_deleting_non_existent_product()
    {
        $user = User::factory()->create();

        $this->productService
            ->shouldReceive('deleteProduct')
            ->with(999)
            ->once()
            ->andThrow(new ModelNotFoundException);

        $response = $this->actingAs($user)->deleteJson('/api/v1/products/999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Product not found'
            ]);
    }

    /** @test */
    public function it_handles_unexpected_errors()
    {
        $user = User::factory()->create();

        $this->productService
            ->shouldReceive('getAllProducts')
            ->with(10)
            ->once()
            ->andThrow(new \Exception('Unexpected error'));

        $response = $this->actingAs($user)->getJson('/api/v1/products');

        $response->assertStatus(500)
            ->assertJson([
                'status' => 'error',
                'message' => 'Failed to retrieve products'
            ]);
    }
}
