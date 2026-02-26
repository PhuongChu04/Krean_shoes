<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Hiển thị danh sách sizes không bị xóa
    public function index()
    {
        $sizes = Size::whereNull('deleted_at')->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    // Hiển thị form create
    public function create()
    {
        return view('admin.sizes.create');
    }

    // Lưu size mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sizes,name|max:255',
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.unique' => 'Size này đã tồn tại',
            'name.max' => 'Tên size không được quá 255 ký tự',
        ]);

        Size::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Tạo size thành công!');
    }

    // Hiển thị form edit
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    // Cập nhật size
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|unique:sizes,name,' . $size->id . '|max:255',
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.unique' => 'Size này đã tồn tại',
            'name.max' => 'Tên size không được quá 255 ký tự',
        ]);

        $size->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Cập nhật size thành công!');
    }
}
