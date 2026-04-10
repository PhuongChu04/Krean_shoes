<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use App\Models\Admin\Category;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        // Tìm theo tên banner
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày tạo
        if ($request->filled('min_date')) {
            $query->whereDate('created_at', '>=', $request->min_date);
        }
        if ($request->filled('max_date')) {
            $query->whereDate('created_at', '<=', $request->max_date);
        }

       $banners = $query->with('category')->latest()->paginate(10);


        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.banners.create', compact('categories'));
    }

    public function store(StoreBannerRequest $request)
    {
        $data = $request->validated();

        // Xử lý ảnh
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images/banners', 'public');
            $data['img'] = 'storage/' . $path;
        }
        //  dd($data);
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được thêm thành công');
    }
}
