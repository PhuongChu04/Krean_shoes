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
    /**
 * Lấy ID của danh mục và tất cả danh mục con (đệ quy)
 */
private function getCategoryAndChildrenIds($category)
{
    $ids = [$category->id];

    // Load children nếu chưa có
    if (!$category->relationLoaded('children')) {
        $category->load('children');
    }

    foreach ($category->children as $child) {
        $ids = array_merge($ids, $this->getCategoryAndChildrenIds($child));
    }

    return array_unique($ids);
}
public function homeClient()
{
    
// Chỉ lấy các danh mục CON (có parent_id)
$categories = Category::whereNotNull('id_parent')
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
// ==================== SẢN PHẨM NAM (Danh mục cha + tất cả danh mục con) ====================
$menCategory = Category::where('name', 'LIKE', '%Nam%')
                       ->whereNull('id_parent')           // Là danh mục cha
                       ->first();

$menProducts = Product::with([
    'variants' => fn($q) => $q->with(['size','color','images'])
                             ->where('stock','>',0)
                             ->whereNull('deleted_at')
])
->whereHas('variants', fn($q) => $q->where('stock','>',0)->whereNull('deleted_at'))
->where('status', 1);

if ($menCategory) {
    $menCategoryIds = $this->getCategoryAndChildrenIds($menCategory);
    $menProducts->whereIn('category_id', $menCategoryIds);
}

$menProducts = $menProducts->inRandomOrder()->take(10)->get();

// ==================== SẢN PHẨM NỮ (Danh mục cha + tất cả danh mục con) ====================
$womenCategory = Category::where('name', 'LIKE', '%Nữ%')
                         ->whereNull('id_parent')           // Là danh mục cha
                         ->first();

$womenProducts = Product::with([
    'variants' => fn($q) => $q->with(['size','color','images'])
                             ->where('stock','>',0)
                             ->whereNull('deleted_at')
])
->whereHas('variants', fn($q) => $q->where('stock','>',0)->whereNull('deleted_at'))
->where('status', 1);

if ($womenCategory) {
    $womenCategoryIds = $this->getCategoryAndChildrenIds($womenCategory);
    $womenProducts->whereIn('category_id', $womenCategoryIds);
}

$womenProducts = $womenProducts->inRandomOrder()->take(10)->get();
// ==================== SẢN PHẨM MỚI ====================
$newProducts = Product::with([
    'variants' => fn($q) => $q->with(['size','color','images'])
                             ->where('stock','>',0)
                             ->whereNull('deleted_at')
])
->whereHas('variants', fn($q) => $q->where('stock','>',0)->whereNull('deleted_at'))
->where('status', 1)
->latest()
->take(8)
->get();

// ==================== SẢN PHẨM BÁN CHẠY NHẤT ====================
$bestSelling = Product::with([
    'variants' => fn($q) => $q->with(['size', 'color', 'images'])
                             ->where('stock', '>', 0)
                             ->whereNull('deleted_at')
])
->whereHas('variants', fn($q) => $q->where('stock', '>', 0)->whereNull('deleted_at'))
->where('status', 1)
->withSum('variants', 'stock')           // ← Thêm dòng này
->orderBy('variants_sum_stock', 'desc')  // ← Sắp xếp theo tổng stock
->take(8)
->get();
   
    return view('client.homeClient', compact(
    'hotDeals', 'categories', 'latestBlogs', 'testimonials',
    'menProducts', 'womenProducts', 'newProducts', 'bestSelling','banners'
));
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
