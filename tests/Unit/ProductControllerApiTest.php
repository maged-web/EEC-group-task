<?php
namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerApiTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->createMock(ProductService::class);
    }

    /** @test */
    public function it_can_list_all_products()
    {
        $this->productService->method('getAll')->willReturn([]);

        $response = $this->json('GET', '/api/products', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_store_a_product()
    {
        Storage::fake('public');

        $productData = [
            'title' => 'Sample Product',
            'description' => 'Sample Description',
            'image' => UploadedFile::fake()->image('product.jpg'),
            'price' => 100.00,
            'quantity' => 10,
        ];

        $this->productService->method('create')->willReturn(new Product($productData));

        $response = $this->json('POST', '/api/products', $productData, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->json('GET', "/api/products/{$product->id}", [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        Storage::fake('public');

        $product = Product::factory()->create();

        $updateData = [
            'title' => 'Updated Product',
            'description' => 'Updated Description',
            'image' => UploadedFile::fake()->image('updated_product.jpg'),
            'price' => 150.00,
            'quantity' => 20,
        ];

        $this->productService->method('update')->willReturn(new Product($updateData));

        $response = $this->json('PUT', "/api/products/{$product->id}", $updateData, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        Storage::fake('public');

        $product = Product::factory()->create();

        $this->productService->method('delete')->willReturn(true);

        $response = $this->json('DELETE', "/api/products/{$product->id}", [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully']);
    }
}
