<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm với các quan hệ
       $products = Product::with([
    'variants' => fn($q) => $q->with(['size', 'color', 'images'])
                           ->where('stock', '>', 0)
                           ->whereNull('deleted_at')
])
->where('status', 1)
->latest()
->paginate(12);

        // Lấy danh sách colors từ variants của sản phẩm đang active
        $colors = Color::whereHas('variants.product', function($query) {
            $query->where('status', 1);
        })->distinct()->get();

        // Lấy danh sách brands có sản phẩm đang active
        $brands = Brand::whereHas('products', function($query) {
            $query->where('status', 1);
        })->get();

        // Lấy danh sách categories có sản phẩm đang active
        $categories = Category::whereHas('products', function($query) {
            $query->where('status', 1);
        })->get();

        // Lấy danh sách sizes từ variants của sản phẩm đang active
        $sizes = Size::whereHas('variants.product', function($query) {
            $query->where('status', 1);
        })->distinct()->get();

        // Tính số lượng sản phẩm còn hàng và hết hàng
        $inStockCount = $products->where('status', 1)->count();
        $outOfStockCount = $products->where('status', 0)->count();
        // dd($products);
        return view('client.shop.shop', compact('products', 'colors', 'brands', 'categories', 'sizes', 'inStockCount', 'outOfStockCount'));
    }


//  public function show($slug)
// {
    
//     // Tìm sản phẩm theo slug, chỉ lấy sản phẩm có ít nhất 1 biến thể còn hàng và chưa xóa mềm
//     $product = Product::with([
//         'category',
//         'brand',

//         // Load variants: còn hàng + chưa xóa mềm
//         'variants' => function ($query) {
//             $query->with(['size', 'color', 'images'])
//                   ->where('stock', '>', 0)           // còn hàng
//                   ->whereNull('deleted_at');         // chưa bị xóa mềm
//         },
        

//         'variants.images',
//         'reviews' => function ($q) {          // ← Thêm dòng này
//             $q->with('user')
//               ->where('status', 'approved')
//               ->latest();
//         }
//     ])
//     ->where('slug', $slug)
//     ->whereHas('variants', function ($q) {           // BẮT BUỘC phải có ít nhất 1 variant hợp lệ
//         $q->where('stock', '>', 0)
//           ->whereNull('deleted_at');
//     })
//     ->first();

//     // Fallback theo ID nếu slug là số
//     if (!$product && is_numeric($slug)) {
//         $product = Product::with([
//             'category',
//             'brand',
//             'variants' => function ($query) {
//                 $query->with(['size', 'color', 'images'])
//                       ->where('stock', '>', 0)
//                       ->whereNull('deleted_at');
//             },
//             'variants.images',
//         ])
//         ->whereHas('variants', function ($q) {
//             $q->where('stock', '>', 0)
//               ->whereNull('deleted_at');
//         })
//         ->find($slug);
//     }

//     // Nếu không tìm thấy sản phẩm hợp lệ → 404
//     if (!$product) {
//         abort(404, 'Sản phẩm không tồn tại hoặc đã hết hàng');
//     }

//     // Lấy danh sách size & color có sẵn từ các variant hợp lệ
//     $availableSizes  = Size::whereIn('id', $product->variants->pluck('size_id'))->get();
//     $availableColors = Color::whereIn('id', $product->variants->pluck('color_id'))->get();

//     // Tính giá thấp nhất & cao nhất
//     $minPrice = $product->variants->min('price') ?? 0;
//     $maxPrice = $product->variants->max('price') ?? 0;

//     // Tổng stock còn lại
//     $totalStock = $product->variants->sum('stock');

//     return view('client.product.detailProduct', compact(
//         'product',
//         'availableSizes',
//         'availableColors',
//         'minPrice',
//         'maxPrice',
//         'totalStock'
//     ));
// }
public function show($slug)
{
    $product = Product::with([
        'category',
        'brand',
        'variants' => function ($query) {
            $query->with(['size', 'color', 'images'])
                  ->where('stock', '>', 0)
                  ->whereNull('deleted_at');
        },
        'variants.images',
    ])
    ->where('slug', $slug)
    ->whereHas('variants', function ($q) {
        $q->where('stock', '>', 0)
          ->whereNull('deleted_at');
    })
    ->first();

    if (!$product && is_numeric($slug)) {
        $product = Product::with([
            'category', 'brand',
            'variants' => fn($q) => $q->with(['size', 'color', 'images'])
                                   ->where('stock', '>', 0)
                                   ->whereNull('deleted_at'),
            'variants.images',
        ])
        ->whereHas('variants', fn($q) => $q->where('stock', '>', 0)->whereNull('deleted_at'))
        ->find($slug);
    }

    if (!$product) {
        abort(404, 'Sản phẩm không tồn tại hoặc đã hết hàng');
    }

    // Load reviews đã duyệt + phân trang
    $reviews = Review::with('user')
        ->whereHas('productVariant', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })
        ->where('status', 'approved')
        ->latest()
        ->paginate(5);

    $availableSizes  = Size::whereIn('id', $product->variants->pluck('size_id'))->get();
    $availableColors = Color::whereIn('id', $product->variants->pluck('color_id'))->get();

    $minPrice = $product->variants->min('price') ?? 0;
    $maxPrice = $product->variants->max('price') ?? 0;
    $totalStock = $product->variants->sum('stock');

    $avgRating = $reviews->avg('rating') ?? 0;

    return view('client.product.detailProduct', compact(
        'product',
        'availableSizes',
        'availableColors',
        'minPrice',
        'maxPrice',
        'totalStock',
        'reviews',
        'avgRating'
    ));
}
    // Nếu bạn muốn route dùng ID thay vì slug (đơn giản hơn)
    // public function show($id)
    // {
    //     $product = Product::with([...])->findOrFail($id);
    //     // ... tương tự như trên
    // }
}
