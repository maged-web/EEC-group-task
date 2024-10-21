<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public'); 
    }

    public function test_index_returns_view_with_products()
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }


    public function test_create_returns_view()
    {
        
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_store_creates_product()
    {
        $data = [
            'title' => 'Test Product',
            'description' => 'Test description',
            'image' => UploadedFile::fake()->create('image.jpg', 500),
            'price' => 99.99,
            'quantity' => 10,
        ];

        $this->post(route('products.store'), $data);

        $this->assertDatabaseHas('products', ['title' => 'Test Product']);
    }

    public function test_show_returns_view_with_product()
    {
        $product = Product::factory()->create(); 

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewHas('product', $product);
    }

    public function test_update_updates_product()
    {
        $product = Product::factory()->create();
        $data = [
            'title' => 'Updated Product',
            'description' => 'Updated description',
            'image' => UploadedFile::fake()->create('image.jpg', 500),
            'price' => 49.99,
            'quantity' => 20,
        ];

        $this->put(route('products.update', $product), $data);

        $this->assertDatabaseHas('products', ['title' => 'Updated Product']);
    }

    public function test_destroy_deletes_product()
    {
        $product = Product::factory()->create();

        $this->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
