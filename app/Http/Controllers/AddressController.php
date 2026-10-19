<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(Address::with('user')->get(), 200);
    }

    public function show($id)
    {
        $address = Address::with('user')->findOrFail($id);

        return response()->json($address, 200);
    }

    public function store(Request $request)
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }
}
