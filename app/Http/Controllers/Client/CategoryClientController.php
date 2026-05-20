<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class CategoryClientController extends Controller
{
public function index(Request $request)
{
    $categoryId = $request->route('id');   // ← Quan trọng: Lấy từ parameter thay vì query string

    $query = Product::with([
        'variants' => function ($q) {
            $q->with(['size', 'color', 'images'])
              ->where('stock', '>', 0)
              ->whereNull('deleted_at');
        },
        'variants.images'
    ])
    ->where('status', 1);

    $category = null;
    if ($categoryId) {
        $category = Category::find($categoryId);
        if ($category) {
            $query->where('category_id', $categoryId);
        }
    }

    $products = $query->latest()->paginate(12);

    $categories = Category::where('status', 1)->get();
    $colors = Color::whereHas('variants.product', fn($q) => $q->where('status', 1))->get();
    $brands = Brand::whereHas('products', fn($q) => $q->where('status', 1))->get();
    $sizes  = Size::whereHas('variants.product', fn($q) => $q->where('status', 1))->get();

    return view('client.category.listProduct', compact(
        'products', 'categories', 'colors', 'brands', 'sizes', 'category'
    ));
}
}
