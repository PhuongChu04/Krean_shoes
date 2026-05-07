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

    ublic function show(Request $request, $id)
    {
        $comment = Comment::with(['product.category', 'user.profile'])->findOrFail($id);

        // Query khởi tạo với comment cùng sản phẩm
        $relatedComments = Comment::where('product_id', $comment->product_id)
            ->where('id', '!=', $comment->id)
            ->with(['user.profile', 'product.category', 'product.brand']);

        // Lọc theo tên user
        if ($request->filled('user_name')) {
            $relatedComments->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $relatedComments->where('status', $request->status);
        }

        // Lọc theo ngày
        if ($request->filled('min_date')) {
            $relatedComments->whereDate('created_at', '>=', $request->min_date);
        }
        if ($request->filled('max_date')) {
            $relatedComments->whereDate('created_at', '<=', $request->max_date);
        }

        // Lọc theo thương hiệu
        if ($request->filled('brand_id')) {
            $relatedComments->whereHas('product.brand', function ($q) use ($request) {
                $q->where('id', $request->brand_id);
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $relatedComments->whereHas('product.category', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }

        $relatedComments = $relatedComments->latest()->paginate(5)->appends($request->query());

        // Lấy danh sách danh mục, thương hiệu để hiển thị form lọc
        $brands = \App\Models\Brand::all();
        $categories = \App\Models\Category::all();

        return view('admin.comments.show', compact(
            'comment',
            'relatedComments',
            'brands',
            'categories',
            'request'
        ));
    }

    public function showAgain(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if ($comment->status === 'ẩn') {
            $comment->update(['status' => 'hiển thị']);
            $comment->user->notify(new CommentStatusNotification($comment, 'approved'));
            return redirect()->back()->with('success', 'Đã hiện lại bình luận.');
        }
        return redirect()->back()->with('error', 'Bình luận không ở trạng thái ẩn.');
    }
}
