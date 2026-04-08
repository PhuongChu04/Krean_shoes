<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use App\Models\Admin\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo Query cơ bản
        $query = Product::with([
            'variants' => fn($q) => $q->with(['size', 'color', 'images'])->whereNull('deleted_at')
        ])->where('status', 1);

        // --- MỤC 2: XỬ LÝ CÁC BỘ LỌC (FILTERS) ---

        // Lọc theo Tình trạng kho (availability)
        if ($request->filled('availability')) {
            if ($request->availability === 'in_stock') {
                $query->whereHas('variants', fn($q) => $q->where('stock', '>', 0));
            } elseif ($request->availability === 'out_stock') {
                $query->whereDoesntHave('variants', fn($q) => $q->where('stock', '>', 0));
            }
        }

        // Lọc theo Thương hiệu (brand)
        if ($request->filled('brands')) {
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Lọc theo Màu sắc (color)
        if ($request->filled('colors')) {
            $colorIds = explode(',', $request->colors);
            $query->whereHas('variants', fn($q) => $q->whereIn('color_id', $colorIds));
        }

        // Lọc theo Kích cỡ (size)
        if ($request->filled('sizes')) {
            $sizeIds = explode(',', $request->sizes);
            $query->whereHas('variants', fn($q) => $q->whereIn('size_id', $sizeIds));
        }

        // Lọc theo Giá (price)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        // --- MỤC 1: XỬ LÝ SẮP XẾP (SORTING) ---
        $sort = $request->input('sort', 'best-selling');

        switch ($sort) {
            case 'a-z':
                $query->orderBy('name', 'asc');
                break;
            case 'z-a':
                $query->orderBy('name', 'desc');
                break;
            case 'price-low-high':
                // Lấy giá min của variants để sắp xếp
                $query->withMin('variants', 'price')->orderBy('variants_min_price', 'asc');
                break;
            case 'price-high-low':
                $query->withMin('variants', 'price')->orderBy('variants_min_price', 'desc');
                break;
            case 'best-selling':
            default:
                // Nếu bảng products của bạn có cột lượt bán, vd 'sold_count' ->orderBy('sold_count', 'desc');
                // Tạm thời dùng latest() nếu chưa có:
                $query->latest();
                break;
        }

        // 2. Thực thi lấy dữ liệu
        $products = $query->paginate(12)->withQueryString();

        // 3. Nếu là request AJAX, chỉ trả về phần HTML của Grid Sản phẩm
        if ($request->ajax()) {
            return view('client.shop.partials.product_grid', compact('products'))->render();
        }

        // 4. Lấy các dữ liệu cho Sidebar (Menu lọc)
        $colors = \App\Models\Admin\Color::whereHas('variants.product', fn($q) => $q->where('status', 1))->distinct()->get();
        $brands = \App\Models\Admin\Brand::whereHas('products', fn($q) => $q->where('status', 1))->get();
        $categories = \App\Models\Admin\Category::whereHas('products', fn($q) => $q->where('status', 1))->get();
        $sizes = \App\Models\Admin\Size::whereHas('variants.product', fn($q) => $q->where('status', 1))->distinct()->get();

        // Đếm tồn kho thực tế dựa trên variants
        $inStockCount = Product::whereHas('variants', fn($q) => $q->where('stock', '>', 0))->where('status', 1)->count();
        $outOfStockCount = Product::whereDoesntHave('variants', fn($q) => $q->where('stock', '>', 0))->where('status', 1)->count();

        return view('client.shop.shop', compact('products', 'colors', 'brands', 'categories', 'sizes', 'inStockCount', 'outOfStockCount'));
    }


    public function show($slug)
    {
        // Tìm sản phẩm theo slug, chỉ lấy sản phẩm có ít nhất 1 biến thể còn hàng và chưa xóa mềm
        $product = Product::with([
            'category',
            'brand',

            // Load variants: còn hàng + chưa xóa mềm
            'variants' => function ($query) {
                $query->with(['size', 'color', 'images'])
                    ->where('stock', '>', 0)           // còn hàng
                    ->whereNull('deleted_at');         // chưa bị xóa mềm
            },

            'variants.images',
        ])
            ->where('slug', $slug)
            ->whereHas('variants', function ($q) {           // BẮT BUỘC phải có ít nhất 1 variant hợp lệ
                $q->where('stock', '>', 0)
                    ->whereNull('deleted_at');
            })
            ->first();

        // Fallback theo ID nếu slug là số
        if (!$product && is_numeric($slug)) {
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
                ->whereHas('variants', function ($q) {
                    $q->where('stock', '>', 0)
                        ->whereNull('deleted_at');
                })
                ->find($slug);
        }

        // Nếu không tìm thấy sản phẩm hợp lệ → 404
        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại hoặc đã hết hàng');
        }

        // Lấy danh sách size & color có sẵn từ các variant hợp lệ
        $availableSizes  = Size::whereIn('id', $product->variants->pluck('size_id'))->get();
        $availableColors = Color::whereIn('id', $product->variants->pluck('color_id'))->get();

        // Tính giá thấp nhất & cao nhất
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
