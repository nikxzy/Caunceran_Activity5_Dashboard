<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function index()
    {
        return response()->json(
            OrderProduct::with(['order', 'product'])->get(),
            200
        );
    }

    public function show($id)
    {
        $productOrder = OrderProduct::with(['order', 'product'])->findOrFail($id);

        return response()->json($productOrder, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $productOrder = OrderProduct::create($validated);

        return response()->json(
            $productOrder->load(['order', 'product']),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $productOrder = OrderProduct::findOrFail($id);

        $validated = $request->validate([
            'order_id' => ['sometimes', 'required', 'exists:orders,id'],
            'product_id' => ['sometimes', 'required', 'exists:products,id'],
            'quantity' => ['sometimes', 'required', 'integer', 'min:1'],
        ]);

        $productOrder->update($validated);

        return response()->json(
            $productOrder->load(['order', 'product']),
            200
        );
    }

    public function destroy($id)
    {
        $productOrder = OrderProduct::findOrFail($id);
        $productOrder->delete();

        return response()->json(null, 204);
    }
}
