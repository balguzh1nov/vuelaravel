<?php

namespace Tests\Unit;

use App\Models\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_shop()
    {
        $shop = Shop::create(['name' => 'Amazon']);
        
        $this->assertDatabaseHas('shops', ['name' => 'Amazon']);
    }

    /** @test */
    public function a_shop_has_many_purchases()
    {
        $shop = Shop::create(['name' => 'Amazon']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shop->purchases);
    }
}
