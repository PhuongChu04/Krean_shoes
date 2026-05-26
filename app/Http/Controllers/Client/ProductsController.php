<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
   public function index(Request $request)
{
    // ==================== QUERY CHÍNH ====================
    $query = Product::with([
        'variants' => function ($q) {
            $q->with(['size', 'color', 'images'])
              ->where('stock', '>', 0)        // Chỉ load variant còn hàng
              ->whereNull('deleted_at')
              ->orderBy('price', 'asc');
        }
    ])
    ->where('status', 1)
    // BẮT BUỘC: Chỉ lấy sản phẩm có ít nhất 1 biến thể còn hàng
    ->whereHas('variants', function ($q) {
        $q->where('stock', '>', 0)
          ->whereNull('deleted_at');
    });

    // ==================== BỘ LỌC ====================

    // Lọc theo Thương hiệu
    if ($request->filled('brands')) {
        $brandIds = explode(',', $request->brands);
        $query->whereIn('brand_id', $brandIds);
    }

    // Lọc theo Màu sắc
    if ($request->filled('colors')) {
        $colorIds = explode(',', $request->colors);
        $query->whereHas('variants', fn($q) => $q->whereIn('color_id', $colorIds));
    }

    // Lọc theo Kích cỡ
    if ($request->filled('sizes')) {
        $sizeIds = explode(',', $request->sizes);
        $query->whereHas('variants', fn($q) => $q->whereIn('size_id', $sizeIds));
    }

    // Lọc theo Giá
    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereHas('variants', function ($q) use ($request) {
            $q->whereBetween('price', [$request->min_price, $request->max_price]);
        });
    }

    // Lọc theo Tình trạng kho (nếu có)
    if ($request->filled('availability')) {
        if ($request->availability === 'out_stock') {
            // Nếu muốn xem hết hàng thì bỏ whereHas ở trên và dùng whereDoesntHave
            $query = Product::with(['variants' => fn($q) => $q->with(['size','color','images'])->whereNull('deleted_at')])
                ->where('status', 1)
                ->whereDoesntHave('variants', fn($q) => $q->where('stock', '>', 0));
        }
        // 'in_stock' thì giữ nguyên query mặc định
    }

    // ==================== SẮP XẾP ====================
    $sort = $request->input('sort', 'best-selling');

    switch ($sort) {
        case 'a-z':
            $query->orderBy('name', 'asc');
            break;
        case 'z-a':
            $query->orderBy('name', 'desc');
            break;
        case 'price-low-high':
            $query->withMin('variants', 'price')->orderBy('variants_min_price', 'asc');
            break;
        case 'price-high-low':
            $query->withMin('variants', 'price')->orderBy('variants_min_price', 'desc');
            break;
        case 'best-selling':
        default:
            $query->latest();
            break;
    }

    // ==================== LẤY DỮ LIỆU ====================
    $products = $query->paginate(12)->withQueryString();

    if ($request->ajax()) {
        return view('client.shop.partials.product_grid', compact('products'))->render();
    }

    // ==================== DỮ LIỆU CHO FILTER ====================
    $colors = Color::whereHas('variants.product', fn($q) => $q->where('status', 1))
                    ->distinct()->get();

    $brands = Brand::whereHas('products', fn($q) => $q->where('status', 1))->get();

    $categories = Category::whereHas('products', fn($q) => $q->where('status', 1))->get();

    $sizes = Size::whereHas('variants.product', fn($q) => $q->where('status', 1))
                 ->distinct()->get();

    // Đếm số lượng
    $inStockCount = Product::where('status', 1)
        ->whereHas('variants', fn($q) => $q->where('stock', '>', 0))
        ->count();

    $outOfStockCount = Product::where('status', 1)
        ->whereDoesntHave('variants', fn($q) => $q->where('stock', '>', 0))
        ->count();

    return view('client.shop.shop', compact(
        'products', 
        'colors', 
        'brands', 
        'categories', 
        'sizes', 
        'inStockCount', 
        'outOfStockCount'
    ));
}



 public function show($slug)
{
    $product = Product::with([
        'category',
        'brand',
        'variants' => function ($query) {
            $query->with(['size', 'color', 'images'])
                  ->whereNull('deleted_at')           // Chỉ lấy variant chưa xóa mềm
                  ->orderBy('price', 'asc');
        },
        'variants.images',
    ])
    ->where('slug', $slug)
    ->where('status', 1)
    ->first();

    // Fallback nếu slug là ID
    if (!$product && is_numeric($slug)) {
        $product = Product::with([
            'category', 'brand', 'variants.images'
        ])->find($slug);
    }

    if (!$product) {
        abort(404, 'Sản phẩm không tồn tại');
    }

    // Kiểm tra sản phẩm còn hàng hay không
    $hasAvailableStock = $product->variants->contains(function ($variant) {
        return $variant->stock > 0;
    });

    // Load reviews
    $reviews = Review::with('user')
        ->whereHas('productVariant', fn($q) => $q->where('product_id', $product->id))
        ->where('status', 'approved')
        ->latest()
        ->paginate(5);

    $availableSizes  = Size::whereIn('id', $product->variants->pluck('size_id'))->get();
    $availableColors = Color::whereIn('id', $product->variants->pluck('color_id'))->get();

    $minPrice = $product->variants->min('price') ?? 0;
    $maxPrice = $product->variants->max('price') ?? 0;
    $totalStock = $product->variants->sum('stock');

    $avgRating = $reviews->avg('rating') ?? 0;

    $comments = Comment::with('user')
        ->where('product_id', $product->id)
        ->where('status', 'hiển thị')
        ->latest()
        ->paginate(5);

    return view('client.product.detailProduct', compact(
        'product',
        'availableSizes',
        'availableColors',
        'minPrice',
        'maxPrice',
        'totalStock',
        'reviews',
        'avgRating',
        'comments',
        'hasAvailableStock'     // ← Truyền biến quan trọng này
    ));
}
    // Nếu bạn muốn route dùng ID thay vì slug (đơn giản hơn)
    // public function show($id)
    // {
    //     $product = Product::with([...])->findOrFail($id);
    //     // ... tương tự như trên
    // }
}
