<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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
}
