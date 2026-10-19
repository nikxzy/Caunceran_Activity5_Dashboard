<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with(['user', 'products'])->get(), 200);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'products'])->findOrFail($id);

        return response()->json($order, 200);
    }

    public function store(Request $request)
    {
        $order = Order::create($request->all());

        return response()->json($order, 201);
    }
}
