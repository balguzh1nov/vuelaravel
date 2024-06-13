<?php

// tests/Feature/ShopControllerTest.php

namespace Tests\Feature;

use App\Models\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_shops()
    {
        Shop::create(['name' => 'Amazon']);
        Shop::create(['name' => 'Spotify']);

        $response = $this->getJson('/shops');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /** @test */
    public function it_can_create_a_shop()
    {
        $response = $this->postJson('/shops', ['name' => 'Amazon']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('shops', ['name' => 'Amazon']);
    }

    /** @test */
    public function it_can_show_a_shop()
    {
        $shop = Shop::create(['name' => 'Amazon']);

        $response = $this->getJson('/shops/' . $shop->id);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Amazon']);
    }

    /** @test */
    public function it_can_update_a_shop()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        
        $response = $this->putJson('/shops/' . $shop->id, ['name' => 'Amazon Updated']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('shops', ['name' => 'Amazon Updated']);
    }

    /** @test */
    public function it_can_delete_a_shop()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        
        $response = $this->deleteJson('/shops/' . $shop->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('shops', ['id' => $shop->id]);
    }
}


