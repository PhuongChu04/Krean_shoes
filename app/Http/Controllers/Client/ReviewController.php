<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'order_item_id'      => 'required|exists:order_items,id',
        'product_variant_id' => 'required|exists:product_variants,id',
        'rating'             => 'required|integer|min:1|max:5',
        'title'              => 'required|string|max:150',
        'content'            => 'required|string|min:10',
    ]);

    // Kiểm tra người dùng đã đánh giá sản phẩm này chưa
    $exists = Review::where('user_id', Auth::id())
                    ->where('order_item_id', $request->order_item_id)
                    ->exists();

    if ($exists) {
        return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
    }

    // Tạo đánh giá
    Review::create([
        'user_id'            => Auth::id(),
        'order_item_id'      => $request->order_item_id,
        'product_variant_id' => $request->product_variant_id,   // ← Dòng này là nguyên nhân lỗi
        'rating'             => $request->rating,
        'title'              => $request->title,
        'content'            => $request->content,
        'status'             => 'pending',
    ]);

    return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm! Đánh giá của bạn đang chờ duyệt.');
}

}
