<?php

namespace Tests\Unit;

use App\Models\Pharmacy;
use App\Services\PharmacyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyControllerTest extends TestCase
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

        $response = $this->get('/pharmacies');

        $response->assertStatus(200)
                 ->assertViewIs('pharmacies.index');
    }

    /** @test */
    public function it_can_show_create_pharmacy_form()
    {
        $response = $this->get('/pharmacies/create');

        $response->assertStatus(200)
                 ->assertViewIs('pharmacies.create');
    }

    /** @test */
    public function it_can_store_a_pharmacy()
    {
        $pharmacyData = [
            'name' => 'Sample Pharmacy',
            'address' => '123 Sample St',
        ];

        $response = $this->post('/pharmacies', $pharmacyData);

        $response->assertRedirect('/pharmacies')
                 ->assertSessionHas('success', 'Pharmacy created successfully.');

        $this->assertDatabaseHas('pharmacies', $pharmacyData);
    }


    /** @test */
    public function it_can_show_edit_pharmacy_form()
    {
        $pharmacy = Pharmacy::factory()->create();

        $response = $this->get("/pharmacies/{$pharmacy->id}/edit");

        $response->assertStatus(200)
                 ->assertViewIs('pharmacies.edit')
                 ->assertViewHas('pharmacy', $pharmacy);
    }

    /** @test */
    public function it_can_update_a_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();
        $updatedData = [
            'name' => 'Updated Pharmacy',
            'address' => '456 Updated St',
        ];

        $response = $this->put("/pharmacies/{$pharmacy->id}", $updatedData);

        $response->assertRedirect('/pharmacies')
                 ->assertSessionHas('success', 'Pharmacy updated successfully.');

        $this->assertDatabaseHas('pharmacies', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_pharmacy()
{
    $pharmacy = Pharmacy::factory()->create();

    $response = $this->delete("/pharmacies/{$pharmacy->id}");

    $response->assertRedirect('/pharmacies')
             ->assertSessionHas('success', 'Pharmacy deleted successfully.');

    $this->assertDatabaseMissing('pharmacies', ['id' => $pharmacy->id]);
}
}
