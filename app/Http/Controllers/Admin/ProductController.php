<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // =========================================================================
    // DANH SÁCH SẢN PHẨM
    // =========================================================================

    public function listProduct(Request $request)
    {
        $query = Product::with([
            'variants' => fn($q) => $q->with(['size', 'color', 'images']),
            'category',
            'brand',
        ]);
 
        // Tìm theo tên sản phẩm
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
 
        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
 
        // Lọc theo trạng thái (status: 1 = đang bán, 0 = ẩn)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
 
        // Lọc theo tồn kho
        if ($request->filled('stock') && $request->stock !== 'all') {
            if ($request->stock === 'in_stock') {
                $query->whereHas('variants', fn($q) => $q->where('stock', '>', 0));
            } elseif ($request->stock === 'out_stock') {
                $query->whereDoesntHave('variants', fn($q) => $q->where('stock', '>', 0));
            }
        }
 
        $products   = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
 
        return view('admin.products.listProduct', compact('products', 'categories'));
    }

    // =========================================================================
    // TẠO SẢN PHẨM
    // =========================================================================

    public function create()
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $sizes      = Size::all();
        $colors     = Color::all();

        return view('admin.products.createProduct', compact('categories', 'brands', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255|unique:products,name',
            'category_id'         => 'required|exists:categories,id',
            'brand_id'            => 'required|exists:brands,id',
            'description'         => 'nullable|string',
            'thumbnail'           => 'nullable|image|max:2048',
            'variants'            => 'required|array|min:1',
            'variants.*.size_id'  => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.price'    => 'required|numeric|min:0',
            'variants.*.stock'    => 'required|integer|min:0',
            'variants.*.images'   => 'nullable|array',
            'variants.*.images.*' => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id'    => $request->brand_id,
            'description' => $request->description,
            'thumbnail'   => null,
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');
            $product->update(['thumbnail' => $path]);
        }

        foreach ($request->variants as $index => $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'size_id'    => $variantData['size_id'],
                'color_id'   => $variantData['color_id'],
                'price'      => $variantData['price'],
                'stock'      => $variantData['stock'],
                'sku'        => $product->id . '-' . $variantData['size_id'] . '-' . $variantData['color_id'] . '-' . time(),
            ]);

            if ($request->hasFile("variants.$index.images")) {
                foreach ($request->file("variants.$index.images") as $image) {
                    $path = $image->store('variants', 'public');
                    ProductImage::create([
                        'product_variant_id' => $variant->id,
                        'image'              => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.listProduct')
            ->with('success', 'Thêm sản phẩm và biến thể thành công!');
    }

    // =========================================================================
    // CHI TIẾT SẢN PHẨM
    // =========================================================================

    public function show($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'variants' => fn($q) => $q->with(['size', 'color', 'images']),
        ])->findOrFail($id);

        // Biến thể đã xóa mềm — hiển thị khu vực riêng trong trang chi tiết
        $trashedVariants = ProductVariant::onlyTrashed()
            ->where('product_id', $id)
            ->with(['size', 'color', 'images'])
            ->latest('deleted_at')
            ->get();

        $sizes  = Size::all();
        $colors = Color::all();

        return view('admin.products.detailProduct', compact('product', 'sizes', 'colors', 'trashedVariants'));
    }

    // =========================================================================
    // SỬA SẢN PHẨM
    // =========================================================================

    public function edit($id)
    {
        $product = Product::with('variants.size', 'variants.color', 'variants.images')->findOrFail($id);

        $categories = Category::all();
        $brands     = Brand::all();
        $sizes      = Size::all();
        $colors     = Color::all();

        return view('admin.products.editProduct', compact('product', 'categories', 'brands', 'sizes', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        $product->update([
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'category_id' => $request->category_id,
            'brand_id'    => $request->brand_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $path = $request->file('thumbnail')->store('products', 'public');
            $product->update(['thumbnail' => $path]);
        }

        return redirect()->route('admin.listProduct')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // =========================================================================
    // XÓA MỀM SẢN PHẨM — chuyển vào thùng rác (KHÔNG xóa file ảnh)
    // =========================================================================

    public function destroy($id)
    {
        $product = Product::with('variants.images')->findOrFail($id);

        $isInOrder = \App\Models\OrderItem::whereHas('variant', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->exists();

        try {
            // Xóa mềm tất cả variant trước
            foreach ($product->variants as $variant) {
                $variant->delete();
            }
            // Xóa mềm sản phẩm
            $product->delete();

            $msg = $isInOrder
                ? 'Sản phẩm đã chuyển vào thùng rác (có trong đơn hàng, sẽ không xóa vĩnh viễn được).'
                : 'Đã chuyển sản phẩm vào thùng rác. Vào thùng rác để xóa vĩnh viễn hoặc khôi phục.';

            return redirect()->route('admin.listProduct')->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->route('admin.listProduct')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // BIẾN THỂ — SỬA / CẬP NHẬT
    // =========================================================================

    public function editVariant(ProductVariant $variant)
    {
        $variant->load(['product', 'size', 'color', 'images']);

        $sizes  = Size::all();
        $colors = Color::all();

        return view('admin.products.productVariant', compact('variant', 'sizes', 'colors'));
    }

    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $variant->update([
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('variants', 'public');
                ProductImage::create([
                    'product_variant_id' => $variant->id,
                    'image'              => $path,
                ]);
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = ProductImage::find($imgId);
                if (!$img || $img->product_variant_id !== $variant->id) continue;

                $usedInOrders = \App\Models\OrderItem::where('product_image', $img->image)->exists();
                if (!$usedInOrders) {
                    Storage::disk('public')->delete($img->image);
                }
                $img->delete();
            }
        }

        return redirect()
            ->route('admin.products.show', $variant->product_id)
            ->with('success', 'Cập nhật biến thể thành công!');
    }

    // =========================================================================
    // BIẾN THỂ — XÓA MỀM (chuyển vào thùng rác, KHÔNG xóa file ảnh)
    // =========================================================================

    public function destroyVariant(ProductVariant $variant)
    {
        $productId = $variant->product_id;

        // Chỉ xóa mềm — file ảnh giữ nguyên để đơn hàng tham chiếu được
        $variant->delete();

        return redirect()
            ->route('admin.products.show', $productId)
            ->with('success', 'Đã chuyển biến thể vào thùng rác.');
    }

    // =========================================================================
    // BIẾN THỂ — THÊM MỚI
    // =========================================================================

    public function storeVariant(Request $request, Product $product)
    {
        $request->validate([
            'size_id'  => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Kiểm tra trùng size + color kể cả biến thể đang trong thùng rác
        $exists = ProductVariant::withTrashed()
            ->where('product_id', $product->id)
            ->where('size_id', $request->size_id)
            ->where('color_id', $request->color_id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['size_id' => 'Biến thể với size và màu này đã tồn tại (kể cả trong thùng rác)!'])
                ->withInput();
        }

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'size_id'    => $request->size_id,
            'color_id'   => $request->color_id,
            'price'      => $request->price,
            'stock'      => $request->stock,
            'sku'        => $product->id . '-' . $request->size_id . '-' . $request->color_id . '-' . time(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('variants', 'public');
                ProductImage::create([
                    'product_variant_id' => $variant->id,
                    'image'              => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.show', $product->id)
            ->with('success', 'Thêm biến thể mới thành công!');
    }

    // =========================================================================
    // API — LẤY THÔNG TIN BIẾN THỂ (dùng cho trang client chọn size/màu)
    // =========================================================================

    public function getVariant(Request $request)
    {
        $productId = $request->query('product_id');
        $sizeId    = $request->query('size_id');
        $colorId   = $request->query('color_id');

        if (!$productId || !$sizeId || !$colorId) {
            return response()->json(['success' => false, 'message' => 'Thiếu tham số'], 400);
        }

        $variant = ProductVariant::with(['color', 'size', 'images'])
            ->where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->where('color_id', $colorId)
            ->first();

        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy biến thể'], 404);
        }

        $mainImage = $variant->images->first()?->image ?? null;

        return response()->json([
            'success' => true,
            'variant' => [
                'id'         => $variant->id,
                'price'      => $variant->price,
                'stock'      => $variant->stock,
                'color_name' => $variant->color?->name,
                'size_name'  => $variant->size?->name,
                'main_image' => $mainImage ? Storage::url($mainImage) : null,
            ],
        ]);
    }

    // =========================================================================
    // THÙNG RÁC — Xem danh sách đã xóa mềm
    // =========================================================================

    public function trash(Request $request)
    {
        $tab = $request->get('tab', 'products');

        // Sản phẩm đã xóa mềm (kèm variant dù đã xóa để hiển thị thống kê)
        $trashedProducts = Product::onlyTrashed()
            ->with([
                'category',
                'variants' => fn($q) => $q->withTrashed()->with(['size', 'color', 'images']),
            ])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'products_page')
            ->withQueryString();

        // Biến thể đã xóa mềm mà sản phẩm cha vẫn còn hoạt động
        $trashedVariants = ProductVariant::onlyTrashed()
            ->whereHas('product')
            ->with(['product', 'size', 'color', 'images'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'variants_page')
            ->withQueryString();

        return view('admin.products.trashProduct', compact('trashedProducts', 'trashedVariants', 'tab'));
    }

    // =========================================================================
    // THÙNG RÁC — Khôi phục / Xóa vĩnh viễn SẢN PHẨM
    // =========================================================================

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        // Khôi phục tất cả variant bị xóa mềm cùng lúc với sản phẩm
        ProductVariant::onlyTrashed()
            ->where('product_id', $id)
            ->restore();

        return redirect()->route('admin.products.trash', ['tab' => 'products'])
            ->with('success', "Đã khôi phục sản phẩm \"{$product->name}\" và toàn bộ biến thể!");
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()
            ->with(['variants' => fn($q) => $q->withTrashed()->with('images')])
            ->findOrFail($id);

        // Không cho xóa vĩnh viễn nếu đã có trong đơn hàng
        $variantIds = $product->variants->pluck('id');
        $isInOrder  = \App\Models\OrderItem::whereIn('product_variant_id', $variantIds)->exists();

        if ($isInOrder) {
            return redirect()->route('admin.products.trash', ['tab' => 'products'])
                ->with('error', 'Không thể xóa vĩnh viễn vì sản phẩm đã xuất hiện trong đơn hàng!');
        }

        foreach ($product->variants as $variant) {
            foreach ($variant->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->forceDelete();
            }
            $variant->forceDelete();
        }

        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $name = $product->name;
        $product->forceDelete();

        return redirect()->route('admin.products.trash', ['tab' => 'products'])
            ->with('success', "Đã xóa vĩnh viễn sản phẩm \"{$name}\"!");
    }

    // =========================================================================
    // THÙNG RÁC — Khôi phục / Xóa vĩnh viễn BIẾN THỂ
    // =========================================================================

    public function restoreVariant($id)
    {
        $variant = ProductVariant::onlyTrashed()
            ->with('product')
            ->findOrFail($id);

        // Nếu sản phẩm cha cũng đang bị xóa mềm thì khôi phục luôn
        if ($variant->product && $variant->product->trashed()) {
            $variant->product->restore();
        }

        $variant->restore();

        // Redirect thông minh: về trang chi tiết sản phẩm nếu gọi từ đó
        $referer = request()->headers->get('referer', '');
        if (str_contains($referer, '/products/' . $variant->product_id)) {
            return redirect()->route('admin.products.show', $variant->product_id)
                ->with('success', 'Đã khôi phục biến thể thành công!');
        }

        return redirect()->route('admin.products.trash', ['tab' => 'variants'])
            ->with('success', 'Đã khôi phục biến thể thành công!');
    }

    public function forceDeleteVariant($id)
    {
        $variant = ProductVariant::onlyTrashed()
            ->with('images')
            ->findOrFail($id);

        $isInOrder = \App\Models\OrderItem::where('product_variant_id', $variant->id)->exists();
        $productId = $variant->product_id;
        $referer   = request()->headers->get('referer', '');

        if ($isInOrder) {
            $msg = 'Không thể xóa vĩnh viễn biến thể này vì đã có trong đơn hàng!';
            if (str_contains($referer, '/products/' . $productId)) {
                return redirect()->route('admin.products.show', $productId)->with('error', $msg);
            }
            return redirect()->route('admin.products.trash', ['tab' => 'variants'])->with('error', $msg);
        }

        foreach ($variant->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->forceDelete();
        }
        $variant->forceDelete();

        $msg = 'Đã xóa vĩnh viễn biến thể!';
        if (str_contains($referer, '/products/' . $productId)) {
            return redirect()->route('admin.products.show', $productId)->with('success', $msg);
        }

        return redirect()->route('admin.products.trash', ['tab' => 'variants'])->with('success', $msg);
    }
}