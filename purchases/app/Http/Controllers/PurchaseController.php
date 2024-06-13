<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return Purchase::with('shop')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'date' => 'required|date',
            'document' => 'required|string'
        ]);

        $purchase = Purchase::create($request->all());

        return response()->json($purchase, 201);
    }

    public function show($id)
    {
        return Purchase::with('shop')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'date' => 'required|date',
            'document' => 'required|string'
        ]);

        // Сохранение файла в S3
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 's3');
            $validatedData['document'] = Storage::disk('s3')->url($path);
        }

        $purchase = Purchase::create($validatedData);

        return response()->json($purchase, 201);

        $purchase = Purchase::findOrFail($id);
        $purchase->update($request->all());

        return response()->json($purchase, 200);
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->json(null, 204);
    }
}
