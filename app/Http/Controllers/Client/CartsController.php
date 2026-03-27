<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cart;
use App\Models\Admin\CartItem;
use App\Models\Admin\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    protected function validateStockQuantity(ProductVariant $variant, int $quantityInCart, int $addedQuantity = 0): void
    {
        $available = $variant->stock ?? 0;

        if ($available < $quantityInCart + $addedQuantity) {
            throw new \Exception("Số lượng bạn thêm vào giỏ vượt quá số lượng sản phẩm trong kho, chỉ còn lại {$available} sản phẩm trong kho.");
        }
    }

    public function getCartData()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để xem giỏ hàng.'
            ], 401);
        }

        $cart = Cart::where(function ($q) {
            $q->where('user_id', Auth::user()->id);
        })
            ->with(['items.productVariant.product', 'items.productVariant.color', 'items.productVariant.size']) // eager load
            ->first();

        // Trả về dữ liệu giỏ hàng
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

   public function addToCart(Request $request)
{
    try {
        // Cho phép gửi hoặc product_variant_id HOẶC (size_id + color_id + product_id)
        $request->validate([
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'product_id'         => 'required_without:product_variant_id|exists:products,id',
            'size_id'            => 'required_without:product_variant_id|exists:sizes,id',
            'color_id'           => 'required_without:product_variant_id|exists:colors,id',
            'quantity'           => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $variant = null;

        if ($request->filled('product_variant_id')) {
            $variant = ProductVariant::findOrFail($request->product_variant_id);
        } else {
            // Tìm variant theo size + color
            $variant = ProductVariant::where('product_id', $request->product_id)
                ->where('size_id', $request->size_id)
                ->where('color_id', $request->color_id)
                ->first();

            if (!$variant) {
                throw new \Exception('Không tìm thấy biến thể với kích thước và màu đã chọn.');
            }
        }

        // Kiểm tra tồn kho
        $this->validateStockQuantity($variant, 0, $request->quantity);

        // Tìm hoặc tạo Cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Kiểm tra item đã tồn tại chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $cartItem->quantity * $variant->price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'            => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity'           => $request->quantity,
                'unit_price'         => $variant->price,
                'total_price'        => $request->quantity * $variant->price,
            ]);
        }

        // Cập nhật tổng tiền giỏ hàng
        $cart->total_amount = $cart->items()->sum('total_price');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng thành công!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 422);
    }
}

    public function index(Request $request)
    {
        return view('client.carts.carts');
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            $quantity = $request->input('quantity');
            $cartItem = CartItem::findOrFail($id);

            // Kiểm tra tồn kho
            $this->validateStockQuantity($cartItem->productVariant, 0, $quantity);

            $total_price = $cartItem->unit_price * $quantity;
            $cartItem->quantity = $quantity;
            $cartItem->total_price = $total_price;
            $cartItem->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function deleteMultiple(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập']);
        }

        $ids = $request->input('ids');

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!',
            ]);
        }

        // Lấy danh sách cart_id của user hiện tại
        $cartIds = Cart::where('user_id', Auth::id())->pluck('id')->toArray();

        if (empty($cartIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy giỏ hàng của người dùng.',
            ]);
        }

        // Lấy cart_id các cart_items sẽ bị xóa
        $affectedCartIds = CartItem::whereIn('id', $ids)
            ->whereIn('cart_id', $cartIds)
            ->pluck('cart_id')
            ->unique()
            ->toArray();

        // Xóa cứng các cart_items có id nằm trong danh sách và cart_id thuộc user đó
        $deleted = CartItem::whereIn('id', $ids)
            ->whereIn('cart_id', $cartIds)
            ->forceDelete();

        foreach ($affectedCartIds as $cartId) {
            $cart = Cart::find($cartId);
            if (!$cart) continue;

            $totalAmount = $cart->items()->sum('total_price') ?? 0;

            // Cập nhật total_amount
            $cart->total_amount = $totalAmount;
            $cart->save();
        }

        return response()->json([
            'success' => $deleted > 0,
            'message' => $deleted > 0 ? null : 'Không thể xoá sản phẩm!',
        ]);
    }
    public function remove($id)
{
    $item = CartItem::findOrFail($id);  // thay bằng model thực tế của bạn

    // Kiểm tra quyền (tùy chọn nhưng nên có)
    // if ($item->cart->user_id !== auth()->id()) {
    //     return response()->json(['success' => false, 'message' => 'Không có quyền'], 403);
    // }

    $item->delete();

    return response()->json([
        'success' => true,
        'message' => 'Đã xóa sản phẩm khỏi giỏ hàng'
    ]);
}
}
