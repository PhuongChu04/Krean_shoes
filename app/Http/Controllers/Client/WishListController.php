<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $productIds = $user->wishlists()->pluck('product_id')->toArray();

        $products = Product::with([
            'variants' => function ($q) {
                $q->with(['size', 'color', 'images'])
                  ->where('stock', '>', 0)
                  ->whereNull('deleted_at');
            }
        ])
        ->where('status', 1)
        ->whereIn('id', $productIds)
        ->whereHas('variants', function ($q) {
            $q->where('stock', '>', 0)
              ->whereNull('deleted_at');
        })
        ->paginate(12);

        return view('client.account.wishlist', compact('products'));
    }
}
