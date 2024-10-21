<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_with_pharmacies()
    {
        $response = $this->get(route('pharmacies.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pharmacies');
    }

    public function test_create_returns_view()
    {
        $response = $this->get(route('pharmacies.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pharmacies.create');
    }

    public function test_store_creates_pharmacy()
    {
        $data = [
            'name' => 'Test Pharmacy',
            'address' => '123 Test St',
        ];

        $this->post(route('pharmacies.store'), $data);

        $this->assertDatabaseHas('pharmacies', ['name' => 'Test Pharmacy']);
    }


    public function test_update_updates_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();
        $data = [
            'name' => 'Updated Pharmacy',
            'address' => '456 Updated St',
        ];

        $this->put(route('pharmacies.update', $pharmacy), $data);

        $this->assertDatabaseHas('pharmacies', ['name' => 'Updated Pharmacy']);
    }

    public function test_destroy_deletes_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();

        $this->delete(route('pharmacies.destroy', $pharmacy));

        $this->assertDatabaseMissing('pharmacies', ['id' => $pharmacy->id]);
    }
}
