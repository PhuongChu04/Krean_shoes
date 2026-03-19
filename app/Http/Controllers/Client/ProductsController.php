<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm với các quan hệ
        $products = Product::with(['variants.color', 'variants.size', 'category', 'brand'])->get();

        // Lấy danh sách colors từ variants của sản phẩm đang active
        $colors = \App\Models\Admin\Color::whereHas('variants.product', function($query) {
            $query->where('status', 1);
        })->distinct()->get();

        // Lấy danh sách brands có sản phẩm đang active
        $brands = \App\Models\Admin\Brand::whereHas('products', function($query) {
            $query->where('status', 1);
        })->get();

        // Lấy danh sách categories có sản phẩm đang active
        $categories = \App\Models\Admin\Category::whereHas('products', function($query) {
            $query->where('status', 1);
        })->get();

        // Lấy danh sách sizes từ variants của sản phẩm đang active
        $sizes = \App\Models\Admin\Size::whereHas('variants.product', function($query) {
            $query->where('status', 1);
        })->distinct()->get();

        // Tính số lượng sản phẩm còn hàng và hết hàng
        $inStockCount = $products->where('status', 1)->count();
        $outOfStockCount = $products->where('status', 0)->count();
        // dd($products);
        return view('client.shop.shop', compact('products', 'colors', 'brands', 'categories', 'sizes', 'inStockCount', 'outOfStockCount'));
    }
}
