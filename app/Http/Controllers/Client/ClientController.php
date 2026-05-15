<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

   
    return view('client.homeClient', compact('hotDeals' , 'categories'));
}
}
