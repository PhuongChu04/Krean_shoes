<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use App\Models\Admin\Product;
use App\Models\Size;
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


 public function show($slug)
    {
        // Ưu tiên tìm theo slug
        $product = Product::with([
            // Load category & brand
            'category',
            'brand',

            // Load variants còn hàng + relations
            'variants' => function ($query) {
                $query->with(['size', 'color', 'images'])
                      ->where('stock', '>', 0) // chỉ variant còn hàng
                      ->orderBy('price', 'asc'); // sắp xếp theo giá tăng dần
            },

            // Load ảnh của variant
            'variants.images',
        ])
        ->where('slug', $slug)
        ->first();

        // Nếu không tìm thấy theo slug, thử fallback theo ID (nếu slug là số)
        if (!$product && is_numeric($slug)) {
            $product = Product::with([
                'category',
                'brand',
                'variants' => fn($q) => $q->with(['size', 'color', 'images'])->where('stock', '>', 0),
                'variants.images',
            ])->find($slug);
        }

        // Nếu vẫn không tìm thấy → 404
        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        // Lấy tất cả size & color có sẵn để hiển thị filter (nếu cần)
        $availableSizes  = Size::whereIn('id', $product->variants->pluck('size_id'))->get();
        $availableColors = Color::whereIn('id', $product->variants->pluck('color_id'))->get();

        // Tính giá thấp nhất & cao nhất để hiển thị range giá
        $minPrice = $product->variants->min('price') ?? 0;
        $maxPrice = $product->variants->max('price') ?? 0;

        // Tổng stock còn lại
        $totalStock = $product->variants->sum('stock');

        return view('client.product.detailProduct', compact(
            'product',
            'availableSizes',
            'availableColors',
            'minPrice',
            'maxPrice',
            'totalStock'
        ));
    }

    // Nếu bạn muốn route dùng ID thay vì slug (đơn giản hơn)
    // public function show($id)
    // {
    //     $product = Product::with([...])->findOrFail($id);
    //     // ... tương tự như trên
    // }
}
