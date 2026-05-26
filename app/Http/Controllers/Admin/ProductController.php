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
    /**
     * Display a listing of the resource.
     */
   public function listProduct()
{
    $products = Product::with([
        'variants' => function ($query) {
            $query->with(['size', 'color', 'images']); // load variants + size/color/images
        },
        'category',
    ])
    ->latest()
    ->paginate(10);

    return view('admin.products.listProduct', compact('products'));
}

    /**
     * Show the form for creating a new resource.
     */
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
    $validated = $request->validate([
       'name' => 'required|string|max:255|unique:products,name',
        'category_id'   => 'required|exists:categories,id',
        'brand_id'      => 'required|exists:brands,id',
        'description'   => 'nullable|string',
        'thumbnail'     => 'nullable|image|max:2048',
        'variants'      => 'required|array|min:1',
        'variants.*.size_id'   => 'required|exists:sizes,id',
        'variants.*.color_id'  => 'required|exists:colors,id',
        'variants.*.price'     => 'required|numeric|min:0',
        'variants.*.stock'     => 'required|integer|min:0',
        'variants.*.images'    => 'nullable|array',
        'variants.*.images.*'  => 'nullable|image|max:2048',
    ]);

    // Tạo sản phẩm chính
    $product = Product::create([
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'category_id' => $request->category_id,
        'brand_id'    => $request->brand_id,
        'description' => $request->description,
        'thumbnail'   => null,
    ]);

    // Upload thumbnail nếu có
    if ($request->hasFile('thumbnail')) {
        $path = $request->file('thumbnail')->store('products', 'public');
        $product->update(['thumbnail' => $path]);
    }

    // Tạo từng biến thể từ mảng variants[]
    foreach ($request->variants as $index => $variantData) {
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'size_id'    => $variantData['size_id'],
            'color_id'   => $variantData['color_id'],
            'price'      => $variantData['price'],
            'stock'      => $variantData['stock'],
            'sku'        => $product->id . '-' . $variantData['size_id'] . '-' . $variantData['color_id'] . '-' . time(),
        ]);

        // Upload ảnh riêng cho biến thể này
        if ($request->hasFile("variants.$index.images")) {
            foreach ($request->file("variants.$index.images") as $image) {
                $path = $image->store('variants', 'public');
                ProductImage::create([
                    'product_variant_id' => $variant->id,
                    'image' => $path,
                ]);
            }
        }
    }

    return redirect()->route('admin.listProduct')
        ->with('success', 'Thêm sản phẩm và biến thể thành công!');
}
// client/ProductsController.php

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
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy biến thể'
        ], 404);
    }

    // Chuẩn bị dữ liệu trả về
    $mainImage = $variant->images->first()?->image ?? null;

    return response()->json([
        'success'     => true,
        'variant'     => [
            'id'          => $variant->id,
            'price'       => $variant->price,
            'stock'       => $variant->stock,
            'color_name'  => $variant->color?->name,
            'size_name'   => $variant->size?->name,
            'main_image'  => $mainImage ? Storage::url($mainImage) : null,
        ]
    ]);
}

    // CHI TIẾT SẢN PHẨM
    public function show($id)
{
    $product = Product::with([
        'category',
        'brand',
        'variants' => fn($q) => $q->with(['size', 'color', 'images']),
    ])->findOrFail($id);

    // Thêm dòng này để truyền sizes & colors cho form thêm variant
    $sizes  = Size::all();
    $colors = Color::all();

    return view('admin.products.detailProduct', compact('product', 'sizes', 'colors'));
}
    // FORM SỬA
    public function edit($id)
    {
        $product = Product::with('variants.size', 'variants.color', 'variants.images')->findOrFail($id);

        $categories = Category::all();
        $brands     = Brand::all();
        $sizes      = Size::all();
        $colors     = Color::all();

        return view('admin.products.editProduct', compact('product', 'categories', 'brands', 'sizes', 'colors'));
    }

    // CẬP NHẬT (cập nhật thông tin cơ bản, giá/stock giữ nguyên cho đơn giản – nếu muốn update variant chi tiết thì cần form phức tạp hơn)
   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name'        => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
        'slug'        => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
        'category_id' => 'required|exists:categories,id',
        'brand_id'    => 'required|exists:brands,id',
        'description' => 'nullable|string',
        'thumbnail'   => 'nullable|image|max:2048',
    ]);

    $data = [
        'name'        => $request->name,
        'slug'        => $request->slug ?: Str::slug($request->name),
        'category_id' => $request->category_id,
        'brand_id'    => $request->brand_id,
        'description' => $request->description,
    ];

    $product->update($data);

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

    // XÓA (đã có, nhưng cải thiện xóa file)
  public function destroy($id)
{
    $product = Product::with('variants.images')->findOrFail($id);

    // ==================== KIỂM TRA SẢN PHẨM CÓ TRONG ĐƠN HÀNG KHÔNG ====================
    $isInOrder = \App\Models\OrderItem::whereHas('variant', function ($query) use ($id) {
        $query->where('product_id', $id);
    })->exists();

    if ($isInOrder) {
        return redirect()->route('admin.listProduct')
            ->with('error', 'Không thể xóa sản phẩm này vì đã có trong đơn hàng của khách!');
    }

    // ==================== TIẾN HÀNH XÓA ====================
    try {
        // Xóa ảnh của các biến thể
        foreach ($product->variants as $variant) {
            foreach ($variant->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
            $variant->delete();
        }

        // Xóa thumbnail của sản phẩm
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return redirect()->route('admin.listProduct')
            ->with('success', 'Xóa sản phẩm và biến thể thành công!');

    } catch (\Exception $e) {
        return redirect()->route('admin.listProduct')
            ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
    }
}
    /**
 * FORM SỬA BIẾN THỂ RIÊNG
 */
public function editVariant(ProductVariant $variant)
{
    $variant->load(['product', 'size', 'color', 'images']);

    $sizes  = Size::all();
    $colors = Color::all();

    return view('admin.products.productVariant', compact('variant', 'sizes', 'colors'));
}

/**
 * CẬP NHẬT BIẾN THỂ
 */
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

    // Thêm ảnh mới
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('variants', 'public');
            ProductImage::create([
                'product_variant_id' => $variant->id,
                'image'              => $path,
            ]);
        }
    }

    // Xóa ảnh cũ — chỉ xóa file nếu không có order nào đang dùng
    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $imgId) {
            $img = ProductImage::find($imgId);
            if (!$img || $img->product_variant_id !== $variant->id) continue;

            $usedInOrders = \App\Models\OrderItem::where('product_image', $img->image)->exists();
            if (!$usedInOrders) {
                Storage::disk('public')->delete($img->image);
            }

            $img->delete(); // Luôn xóa record DB
        }
    }

    return redirect()
        ->route('admin.products.show', $variant->product_id)
        ->with('success', 'Cập nhật biến thể thành công!');
}

/**
 * XÓA BIẾN THỂ RIÊNG (tùy chọn)
 */
public function destroyVariant(ProductVariant $variant)
{
    $productId = $variant->product_id;

    foreach ($variant->images as $image) {
        // Chỉ xóa file vật lý nếu KHÔNG có order nào đang dùng
        $usedInOrders = \App\Models\OrderItem::where('product_image', $image->image)->exists();
        
        if (!$usedInOrders) {
            Storage::disk('public')->delete($image->image);
        }
        
        $image->delete(); // Luôn xóa record DB
    }

    $variant->delete();

    return redirect()
        ->route('admin.products.show', $productId)
        ->with('success', 'Xóa biến thể thành công!');
}
public function storeVariant(Request $request, Product $product)
{
    $validated = $request->validate([
        'size_id'    => 'required|exists:sizes,id',
        'color_id'   => 'required|exists:colors,id',
        'price'      => 'required|numeric|min:0',
        'stock'      => 'required|integer|min:0',
        'images.*'   => 'nullable|image|max:2048',

        // Ngăn trùng size + color cho cùng product (tùy chọn nhưng nên có)
        'size_id'    => Rule::unique('product_variants')
            ->where(fn($query) => $query->where('product_id', $product->id))
            ->where('color_id', $request->color_id)
            ->whereNull('deleted_at'), // nếu dùng soft delete
    ]);

    // Kiểm tra unique size + color (nếu validate Rule ở trên không đủ)
    $exists = ProductVariant::where('product_id', $product->id)
        ->where('size_id', $request->size_id)
        ->where('color_id', $request->color_id)
        ->exists();

    if ($exists) {
        return back()->withErrors(['size_id' => 'Biến thể với size và màu này đã tồn tại!'])->withInput();
    }

    $variant = ProductVariant::create([
        'product_id' => $product->id,
        'size_id'    => $request->size_id,
        'color_id'   => $request->color_id,
        'price'      => $request->price,
        'stock'      => $request->stock,
        'sku'        => $product->id . '-' . $request->size_id . '-' . $request->color_id . '-' . time(),
    ]);

    // Upload ảnh nếu có
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('variants', 'public');
            ProductImage::create([
                'product_variant_id' => $variant->id,
                'image' => $path,
            ]);
        }
    }

    return redirect()
        ->route('admin.products.show', $product->id)
        ->with('success', 'Thêm biến thể mới thành công!');
}
}