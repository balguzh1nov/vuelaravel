<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        return response()->json([
            'rates' => [
                'USD_EUR' => 0.85,
                'EUR_USD' => 1.18,
                'USD_RUB' => 74,
                'RUB_USD' => 0.0135,
                'EUR_RUB' => 86.45,
                'RUB_EUR' => 0.0116,
            ],
        ]);
    }
}
