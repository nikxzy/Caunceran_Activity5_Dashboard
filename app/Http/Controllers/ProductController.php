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
        // Category Totals & Averages
        $categoryTotals = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(products.price) as total_price'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $categoryAverages = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('AVG(products.price) as avg_price'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return response()->json([
            'totalProducts' => Product::count(),
            'totalValue' => Product::sum('price'),
            'avgPrice' => Product::avg('price'),
            'maxPrice' => Product::max('price'),
            'minPrice' => Product::min('price'),
            'categoryTotals' => $categoryTotals,
            'categoryAverages' => $categoryAverages,
        ]);
    }
}