<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // public function homeClient()
    // {
    //     return view('client.homeClient');
    // }
    
    // Trong ClientController.php
public function homeClient()
{
    
$categories = Category::with('children')  // load danh mục con nếu có
                    ->orderBy('name')
                    ->get();

   $hotDeals = Product::with([
        'variants' => function ($query) {
            $query->with(['size', 'color', 'images'])           // Load quan hệ
                  ->where('stock', '>=', 1)                      // Chỉ biến thể còn hàng
                  ->whereNull('deleted_at');                    // Không lấy biến thể đã xóa mềm
        },
        'variants.images',
    ])
    ->whereHas('variants', function ($q) {                    // Chỉ sản phẩm có ít nhất 1 variant hợp lệ
        $q->where('stock', '>=', 1)
          ->whereNull('deleted_at');                          // Không tính variant đã xóa mềm
    })
    ->where('status', 1)                                      // (Tùy chọn) Chỉ sản phẩm đang active
    ->latest()
    ->take(8)
    ->get();
$testimonials = \App\Models\Review::with(['user', 'productVariant.product'])
        ->where('rating', 5)
        ->where('status', 'approved')
        ->whereHas('productVariant.product', function ($q) {
            $q->where('status', 1);
        })
        ->whereHas('productVariant', function ($q) {
            $q->where('stock', '>', 0)
              ->whereNull('deleted_at');
        })
        ->latest()
        ->take(6)                    // Lấy tối đa 6 đánh giá
        ->get();

    $latestBlogs = \App\Models\Blog::with(['category', 'author'])
                    ->where('status', 1)           // chỉ lấy bài đã publish
                    ->latest()
                    ->take(4)                      // lấy 4 bài (phù hợp swiper)
                    ->get();

    $banners = Banner::where('type', 'slider')
        ->where('status', 1)
        ->orderByDesc('priority')
        ->orderByDesc('id')
        ->get();
   
    return view('client.homeClient', compact('hotDeals' , 'categories', 'latestBlogs','testimonials','banners'));
}
public function searchResults(Request $request)
{
    $keyword = trim($request->get('q'));

    if (empty($keyword)) {
        return redirect()->route('shop.index');
    }

    $products = Product::with([
        'variants' => function ($q) {
            $q->with(['size', 'color', 'images'])
              ->where('stock', '>', 0)           // Biến thể phải còn hàng
              ->whereNull('deleted_at');         // Chưa bị xóa mềm
        },
        'variants.images'
    ])
    ->where('status', 1)                         // Sản phẩm đang active
    ->where(function($q) use ($keyword) {
        $q->where('name', 'like', "%{$keyword}%")
          ->orWhere('slug', 'like', "%{$keyword}%")
          ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$keyword}%"));
    })
    // BẮT BUỘC: Chỉ lấy sản phẩm có ít nhất 1 biến thể hợp lệ
    ->whereHas('variants', function ($q) {
        $q->where('stock', '>', 0)
          ->whereNull('deleted_at');
    })
    ->latest()
    ->paginate(12)
    ->withQueryString();

    return view('client.search.results', compact('products', 'keyword'));
}
}
