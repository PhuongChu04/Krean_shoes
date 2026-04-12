<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\blog\StoreBlogRequest;
use App\Http\Requests\admin\blog\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết (chưa bị xóa), kèm theo thông tin thể loại (category)
        $blogs = Blog::with(['category', 'author'])->latest()->paginate(10); // Thêm author
        // Đếm số bài viết đã bị soft delete
        $deleteCount = Blog::onlyTrashed()->count();

        // Trả về view kèm dữ liệu
        return view('admin.blog.index', compact('blogs', 'deleteCount'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $relatedBlogs = Blog::where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(5)
            ->get();
        return view('admin.blog.show', compact('blog', 'relatedBlogs'));
    }
}
