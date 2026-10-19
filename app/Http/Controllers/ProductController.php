<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\V1\ProductResource;
use App\Traits\ApiResponses; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB; 

class ProductController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $products = Product::with('category')->paginate(10);

        return $this->ok(
            'Products retrieved successfully',
            ProductResource::collection($products)
        );
    }

    public function show(Product $product)
    {
        $product->load('category');

        return $this->ok(
            'Product retrieved successfully',
            new ProductResource($product)
        );
    }

    public function query()
    {
        $nameAndPrice = Product::select('name', 'price')->get()->map(function ($item) {
            $item->price = number_format($item->price, 2, '.', '');
            return $item;
        });

        $productsWithCategory = Product::with('category')->get()->map(function ($product) {
            if ($product->price) {
                $product->price = number_format($product->price, 2, '.', '');
            }
            return $product;
        });

        $productsOrderedByPrice = Product::select('id', 'name', 'price')
            ->orderBy('price', 'asc')
            ->get()
            ->map(function ($item) {
                $item->price = number_format($item->price, 2, '.', '');
                return $item;
            });

        $firstFiveProducts = Product::limit(5)->get()->map(function ($product) {
            if ($product->price) {
                $product->price = number_format($product->price, 2, '.', '');
            }
            return $product;
        });

        $priceGreaterThanOrEqual = Product::where('price', '>=', 3)->get()->map(function ($product) {
            if ($product->price) {
                $product->price = number_format($product->price, 2, '.', '');
            }
            return $product;
        });

        $electronics = Product::whereHas('category', function ($query) {
            $query->where('name', 'Electronics');
        })->get()->map(function ($product) {
            if ($product->price) {
                $product->price = number_format($product->price, 2, '.', '');
            }
            return $product;
        });

        $totalPrice = number_format(Product::sum('price'), 2, '.', '');
        $averagePrice = number_format(Product::avg('price'), 2, '.', '');
        $highestPrice = number_format(Product::max('price'), 2, '.', '');
        $lowestPrice = number_format(Product::min('price'), 2, '.', '');

        $totalPricePerCategory = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select('categories.name', DB::raw('SUM(products.price) as total_price'))
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item) {
                $item->total_price = number_format($item->total_price, 2, '.', '');
                return $item;
            });

        $averagePricePerCategory = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select('categories.name', DB::raw('AVG(products.price) as avg_price'))
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item) {
                $item->avg_price = number_format($item->avg_price, 2, '.', '');
                return $item;
            });

        $lowestPricePerCategory = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select('categories.name', DB::raw('MIN(products.price) as min_price'))
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item) {
                $item->min_price = number_format($item->min_price, 2, '.', '');
                return $item;
            });

        $averagePriceSorted = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->select('categories.name', DB::raw('AVG(products.price) as avg_price'))
            ->groupBy('categories.name')
            ->orderBy('avg_price', 'asc')
            ->get()
            ->map(function ($item) {
                $item->avg_price = number_format($item->avg_price, 2, '.', '');
                return $item;
            });

        $electronicsAndBooks = Product::join(
            'categories',
            'products.category_id',
            '=',
            'categories.id'
        )
            ->whereIn('categories.name', ['Electronics', 'Books'])
            ->select('categories.name', DB::raw('AVG(products.price) as avg_price'))
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item) {
                $item->avg_price = number_format($item->avg_price, 2, '.', '');
                return $item;
            });

        $queryResults = [
            'name_and_price' => $nameAndPrice,
            'products_with_category' => $productsWithCategory,
            'products_ordered_by_price' => $productsOrderedByPrice,
            'first_five_products' => $firstFiveProducts,
            'price_greater_than_or_equal' => $priceGreaterThanOrEqual,
            'electronics' => $electronics,
            'total_price' => $totalPrice,
            'average_price' => $averagePrice,
            'highest_price' => $highestPrice,
            'lowest_price' => $lowestPrice,
            'total_price_per_category' => $totalPricePerCategory,
            'average_price_per_category' => $averagePricePerCategory,
            'lowest_price_per_category' => $lowestPricePerCategory,
            'average_price_sorted' => $averagePriceSorted,
            'electronics_and_books' => $electronicsAndBooks,
        ];

        return $this->success('Query results retrieved successfully', $queryResults);
    }

    private function formatProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category?->name ?? $product->getAttribute('category'),
            'price' => number_format($product->price, 2, '.', ''),
            'quantity' => $product->quantity,
            'status' => $product->status,
        ];
    }
}