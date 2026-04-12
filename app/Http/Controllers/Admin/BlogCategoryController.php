<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Đếm cho tabs
        $all = BlogCategory::withTrashed()->get();
        $active = BlogCategory::whereNull('deleted_at')->get();
        $Trashed = BlogCategory::onlyTrashed()->get();

        $query = BlogCategory::query();

        // Filter theo search (tên hoặc slug)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Filter trạng thái
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereNull('deleted_at');
            }
            if ($request->status == 'deleted') {
                $query->onlyTrashed();
            }
        }

        // Filter ngày tạo
        if ($request->filled('min_date')) {
            $query->whereDate('created_at', '>=', $request->min_date);
        }
        if ($request->filled('max_date')) {
            $query->whereDate('created_at', '<=', $request->max_date);
        }

        $categories = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.blog_categories.index', [
            'categories' => $categories,
            'all' => $all,
            'active' => $active,
            'Trashed' => $Trashed,
            'title' => 'Danh sách danh mục',
        ]);
    }

    public function create()
    {
        return view('admin.blog_categories.create', [
            'title' => 'Thêm danh mục blog mới',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);

        BlogCategory::create($data);

        return redirect()->route('admin.blog_categories.index')
            ->with('success', 'Thêm danh mục blog thành công.');
    }
}
