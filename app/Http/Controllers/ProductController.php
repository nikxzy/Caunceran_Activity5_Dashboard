<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\V1\ProductResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $products = Product::paginate(10);
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function queries()
    {
        return response()->json([
            'totalProducts' => Product::count(),
            'totalValue' => Product::sum('price'),
            'avgPrice' => Product::avg('price'),
            'maxPrice' => Product::max('price'),
            'minPrice' => Product::min('price'),
        ]);
    }
}