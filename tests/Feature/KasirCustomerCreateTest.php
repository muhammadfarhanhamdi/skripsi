<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirCustomerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_see_existing_member_names_on_create_page(): void
    {
        $kasir = User::factory()->create([
            'role' => 'kasir',
        ]);

        Customer::create([
            'name' => 'Sinta Member',
            'phone' => '081234567890',
            'email' => 'sinta@example.com',
            'notes' => 'Member aktif',
            'is_member' => true,
        ]);

        Customer::create([
            'name' => 'Budi Biasa',
            'phone' => '081234567891',
            'email' => 'budi@example.com',
            'notes' => 'Bukan member',
            'is_member' => false,
        ]);

        $response = $this->actingAs($kasir)->get(route('kasir.customers.create'));

        $response->assertStatus(200)
            ->assertSee('Daftar member yang sudah ada')
            ->assertSee('Sinta Member');
    }
}
