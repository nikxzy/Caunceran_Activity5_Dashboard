<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function show($id)
    {
        return response()->json(User::with('addresses', 'orders', 'reviews')->findOrFail($id), 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}