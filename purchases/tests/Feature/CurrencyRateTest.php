<?php

// tests/Feature/CurrencyRateTest.php

namespace Tests\Feature;

use App\Models\CurrencyRate;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyRateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_currency_rates()
    {
        CurrencyRate::create([
            'currency' => 'USD',
            'rate' => 1.2345
        ]);

        $response = $this->get('/api/currency-rates');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
