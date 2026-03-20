<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
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
    // Lấy hot deals: sản phẩm có stock tổng > 0, sắp xếp theo mới nhất hoặc stock thấp
    $hotDeals = Product::with([
        'variants' => function ($query) {
            $query->with(['size', 'color', 'images']) // eager load variants + relations
                  ->where('stock', '>', 0); // chỉ variant còn hàng
        },
        'variants.images', // ảnh của variant
    ])
    ->whereHas('variants', function ($q) { // chỉ sản phẩm có ít nhất 1 variant còn hàng
        $q->where('stock', '>', 0);
    })
    ->latest() // mới nhất
    ->take(8)  // lấy 8 sản phẩm cho hot deals (hoặc paginate nếu cần)
    ->get();

    // Truyền vào view
    return view('client.homeClient', compact('hotDeals'));
}
}
