<?php

namespace Tests\Unit;

use App\Models\Pharmacy;
use App\Services\PharmacyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyControllerApiTest extends TestCase
{
    use RefreshDatabase;

    protected $pharmacyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pharmacyService = $this->createMock(PharmacyService::class);
    }

    /** @test */
    public function it_can_list_all_pharmacies()
    {
        $this->pharmacyService->method('getAll')->willReturn([]);

        $response = $this->json('GET', '/api/pharmacies', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_store_a_pharmacy()
    {
        $pharmacyData = [
            'name' => 'Sample Pharmacy',
            'address' => '123 Sample St',
        ];

        $this->pharmacyService->method('create')->willReturn(new Pharmacy($pharmacyData));

        $response = $this->json('POST', '/api/pharmacies', $pharmacyData, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_show_a_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();

        $response = $this->json('GET', "/api/pharmacies/{$pharmacy->id}", [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_update_a_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();

        $updateData = [
            'name' => 'Updated Pharmacy',
            'address' => '456 Updated St',
        ];

        $this->pharmacyService->method('update')->willReturn(new Pharmacy($updateData));

        $response = $this->json('PUT', "/api/pharmacies/{$pharmacy->id}", $updateData, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data']);
    }

    /** @test */
    public function it_can_delete_a_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();

        $this->pharmacyService->method('delete')->willReturn(true);

        $response = $this->json('DELETE', "/api/pharmacies/{$pharmacy->id}", [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Pharmacy deleted successfully']);
    }
}
