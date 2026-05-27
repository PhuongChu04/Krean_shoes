<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();

    $wishlistProductIds = $user->wishlists()->pluck('product_id')->toArray();

    $products = Product::with([
        'variants' => function ($q) {
            $q->with(['size', 'color', 'images'])
              ->where('stock', '>', 0)
              ->whereNull('deleted_at');
        }
    ])
    ->where('status', 1)
    ->whereIn('id', $wishlistProductIds)
    ->whereHas('variants', function ($q) {
        $q->where('stock', '>', 0)->whereNull('deleted_at');
    })
    ->paginate(12);

    return view('client.account.wishlist', compact('products', 'wishlistProductIds'));
}
    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $user->wishlists()->updateOrCreate(
            ['product_id' => $product->id],
            ['add_at' => now()]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào yêu thích.',
            ]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào yêu thích.');
    }

    public function destroy(Request $request, Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login');
        }

        $user->wishlists()->where('product_id', $product->id)->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi yêu thích.',
            ]);
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi yêu thích.');
    }
}
