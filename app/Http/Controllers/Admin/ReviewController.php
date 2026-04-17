<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with([
            'user',
            'productVariant.product',
            'productVariant.color',
            'productVariant.size'
        ])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        $reviews = $query->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load([
            'user',
            'productVariant.product',
            'productVariant.color',
            'productVariant.size',
            'orderItem'
        ]);

        return view('admin.reviews.show', compact('review'));
    }

    public function reply(Request $request, Review $review)
    {
      $request->validate([
            'reply' => 'required|string|min:10|max:1000',
        ]);

        $review->update([
            'reply'      => $request->reply,
            'replied_at' => now(),
            'replied_by' => Auth::id(),        // ← Sửa thành Auth::id()
            'status'     => 'approved',
        ]);

        return back()->with('success', 'Đã phản hồi đánh giá thành công!');
    }

      

   public function updateStatus(Review $review, Request $request)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',   // ← Chỉ cho phép 3 giá trị này
    ]);

    $review->update([
        'status' => $request->status
    ]);

    return back()->with('success', 'Cập nhật trạng thái đánh giá thành công!');
}
}
