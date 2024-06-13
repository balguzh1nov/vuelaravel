<?php

namespace Tests\Unit;

use App\Models\Shop;
use App\Models\Purchase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_purchase()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        $purchase = Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);
        
        $this->assertDatabaseHas('purchases', [
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);
    }

    /** @test */
    public function a_purchase_belongs_to_a_shop()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        $purchase = Purchase::create([
            'shop_id' => $shop->id,
            'date' => '2024-01-01',
            'amount' => 100.50,
            'currency' => 'USD',
            'document' => 'document.pdf'
        ]);

        $this->assertInstanceOf(Shop::class, $purchase->shop);
    }
}
