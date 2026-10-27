<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'content' => $request->input('content') ?? $request->input('message'),
        ]);

        return response()->json($post, 201);
    }
}