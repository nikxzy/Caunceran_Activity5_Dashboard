<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json(Review::with(['user', 'product'])->get(), 200);
    }

    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);

        return response()->json($review, 200);
    }

    public function store(Request $request)
    {
        $review = Review::create($request->all());

        return response()->json($review, 201);
    }
}
