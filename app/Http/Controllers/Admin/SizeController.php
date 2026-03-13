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
            'name' => 'required|in:35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50|unique:sizes,name',
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.in' => 'Size phải là một trong các số: 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50',
            'name.unique' => 'Size này đã tồn tại',
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
            'name' => 'required|in:35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50|unique:sizes,name,' . $size->id,
        ], [
            'name.required' => 'Tên size không được để trống',
            'name.in' => 'Size phải là một trong các số: 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50',
            'name.unique' => 'Size này đã tồn tại',
        ]);

        $size->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Cập nhật size thành công!');
    }

    // Xóa mềm size
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Xóa size thành công!');
    }

    // Hiển thị thùng rác
    public function trash()
    {
        $sizes = Size::onlyTrashed()->get();
        return view('admin.sizes.trash', compact('sizes'));
    }

    // Khôi phục size
    public function restore($id)
    {
        $size = Size::onlyTrashed()->find($id);
        
        if ($size) {
            $size->restore();
            return redirect()->route('admin.sizes.trash')->with('success', 'Khôi phục size thành công!');
        }

        return redirect()->route('admin.sizes.trash')->with('error', 'Size không tồn tại!');
    }

    // Xóa vĩnh viễn
    public function forceDelete($id)
    {
        $size = Size::onlyTrashed()->find($id);
        
        if ($size) {
            $size->forceDelete();
            return redirect()->route('admin.sizes.trash')->with('success', 'Xóa size vĩnh viễn thành công!');
        }

        return redirect()->route('admin.sizes.trash')->with('error', 'Size không tồn tại!');
    }
}
