<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|min:5|max:255',
        ], [
            'product_id.required' => 'Sản phẩm không hợp lệ.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.string' => 'Nội dung bình luận phải là chuỗi ký tự.',
            'content.min' => 'Nội dung bình luận phải có ít nhất 5 ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá 255 ký tự.',
        ]);

        $user = Auth::user();

        Comment::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'content' => $request->content,
            'status' => 'chưa duyệt',
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi. Vui lòng chờ admin duyệt.');
    }
}
