<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogClientController extends Controller
{
    public function show($slug)
{
    $blog = Blog::where('slug', $slug)->firstOrFail();

    $relatedBlogs = Blog::where('blog_category_id', $blog->blog_category_id)
                        ->where('id', '!=', $blog->id)
                        ->where('status', 1)        // thêm nếu có
                        ->latest()
                        ->take(5)
                        ->get();

    return view('client.blogs.blogDetail', compact('blog', 'relatedBlogs'));
}
public function index(Request $request)
{
    $query = Blog::with(['category', 'author'])
                 ->where('status', 1)           // chỉ lấy bài đã active
                 ->latest();

    // Tìm kiếm theo từ khóa
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    // Lọc theo danh mục
    if ($request->has('category')) {
        $query->where('blog_category_id', $request->category);
    }

    $blogs = $query->paginate(9);   // 9 bài mỗi trang

    $categories = BlogCategory::all();

    return view('client.blogs.blog', compact('blogs', 'categories'));
}
}
