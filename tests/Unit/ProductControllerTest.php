<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
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

        $response = $this->get('/products');

        $response->assertStatus(200)
                 ->assertViewIs('products.index');
    }

    /** @test */
    public function it_can_show_create_product_form()
    {
        $response = $this->get('/products/create');

        $response->assertStatus(200)
                 ->assertViewIs('products.create');
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

        $response = $this->post('/products', $productData);

        $response->assertRedirect('/products')
                 ->assertSessionHas('success', 'Product created successfully.');

        $this->assertDatabaseHas('products', [
            'title' => 'Sample Product',
            'description' => 'Sample Description',
            'price' => 100.00,
            'quantity' => 10,
        ]);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get("/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertViewIs('products.show')
                 ->assertViewHas('product', $product);
    }

    /** @test */
    public function it_can_show_edit_product_form()
    {
        $product = Product::factory()->create();

        $response = $this->get("/products/{$product->id}/edit");

        $response->assertStatus(200)
                 ->assertViewIs('products.edit')
                 ->assertViewHas('product', $product);
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

        $response = $this->put("/products/{$product->id}", $updateData);

        $response->assertRedirect('/products')
                 ->assertSessionHas('success', 'Product updated successfully.');

        $this->assertDatabaseHas('products', [
            'title' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 150.00,
            'quantity' => 20,
        ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        Storage::fake('public');

        $product = Product::factory()->create();

        $this->productService->method('delete')->willReturn(true);

        $response = $this->delete("/products/{$product->id}");

        $response->assertRedirect('/products')
                 ->assertSessionHas('success', 'Product deleted successfully.');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
