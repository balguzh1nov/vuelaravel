<?php
// tests/Feature/PurchaseControllerTest.php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\Purchase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_purchases()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);

        $response = $this->getJson('/purchases');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    /** @test */
    public function it_can_create_a_purchase()
    {
        Storage::fake('local');
        
        $shop = Shop::create(['name' => 'Amazon']);
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->postJson('/purchases', [
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => $file
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('purchases', ['shop_id' => $shop->id]);
        Storage::disk('local')->assertExists('documents/' . $file->hashName());
    }

    /** @test */
    public function it_can_show_a_purchase()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        $purchase = Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);

        $response = $this->getJson('/purchases/' . $purchase->id);

        $response->assertStatus(200);
        $response->assertJson(['amount' => 100.50]);
    }

    /** @test */
    public function it_can_update_a_purchase()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        $purchase = Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);

        $response = $this->putJson('/purchases/' . $purchase->id, [
            'date' => '2024-02-01',
            'amount' => 200.00,
            'currency' => 'USD'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('purchases', ['amount' => 200.00]);
    }

    /** @test */
    public function it_can_delete_a_purchase()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        $purchase = Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);

        $response = $this->deleteJson('/purchases/' . $purchase->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('purchases', ['id' => $purchase->id]);
    }
}
