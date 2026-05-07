<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\CommentStatusNotification;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::with(['product', 'user'])->latest();

        // Lọc theo tên sản phẩm (input product_name)
        if ($request->filled('product_name')) {
            $comments->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product_name . '%');
            });
        }

        // Lọc theo ngày
        if ($request->filled('from_date')) {
            $comments->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $comments->whereDate('created_at', '<=', $request->to_date);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $comments->where('status', $request->status);
        }

        // Lọc theo tên user
        if ($request->filled('user_name')) {
            $comments->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        $comments = $comments->paginate(10);

        // Nếu bạn muốn dùng danh sách sản phẩm (ví dụ cho dropdown hoặc autocomplete), giữ lấy tất cả
        $products = Product::all();

        return view('admin.comments.index', [
            'title' => 'Quản lý bình luận',
            'comments' => $comments,
            'products' => $products,
            'request' => $request,
        ]);
    }
}
