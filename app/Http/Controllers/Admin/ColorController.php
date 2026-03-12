<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use App\Models\Color as ModelsColor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    /**
     * Hiển thị danh sách màu (có phân trang)
     */
    public function list()
    {
        $colors = Color::latest()->paginate(15);
        return view('admin.color.listColor', compact('colors'));
    }

    /**
     * Hiển thị form thêm màu mới
     */
    public function create()
    {
        return view('admin.color.createColor');
    }

    /**
     * Lưu màu mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'code' => 'required|regex:/^#[0-9A-Fa-f]{6}$/|unique:colors,code',
        ]);

       Color::create($validated);

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Thêm màu sắc thành công!');
    }

    /**
     * Hiển thị form sửa màu
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.editColor', compact('color'));
    }

    /**
     * Cập nhật thông tin màu
     */
    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors', 'name')->ignore($color->id),
            ],
            'code' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
                Rule::unique('colors', 'code')->ignore($color->id),
            ],
        ]);

        $color->update($validated);

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Cập nhật màu sắc thành công!');
    }

    /**
     * Xóa mềm (soft delete) một màu
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        // Kiểm tra nếu màu đang được sử dụng trong biến thể sản phẩm
        if ($color->variants()->exists()) {
            return redirect()->back()
                ->with('error', 'Không thể xóa màu này vì đang được sử dụng trong sản phẩm.');
        }

        $color->delete();

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Xóa màu thành công!');
    }

    /**
     * Hiển thị danh sách màu đã xóa mềm (thùng rác)
     */
    public function trash()
    {
        $trashedColors = Color::onlyTrashed()->latest()->get();
        return view('admin.color.trashColor', compact('trashedColors'));
    }

    /**
     * Khôi phục một màu đã xóa mềm
     */
    public function restore($id)
    {
        $color = Color::withTrashed()->findOrFail($id);
        $color->restore();

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Khôi phục màu thành công!');
    }

    /**
     * Xóa vĩnh viễn một màu
     */
    public function forceDelete($id)
    {
        $color = Color::withTrashed()->findOrFail($id);

        // Kiểm tra lại relationship (có thể bỏ nếu không cần)
        if ($color->variants()->withTrashed()->exists()) {
            return redirect()->back()
                ->with('error', 'Không thể xóa vĩnh viễn vì màu vẫn liên kết với sản phẩm.');
        }

        $color->forceDelete();

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Xóa vĩnh viễn màu thành công!');
    }

    /**
     * Xóa mềm hàng loạt (bulk soft delete)
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Không có mục nào được chọn');
        }

        // Kiểm tra trước khi xóa (tùy chọn, có thể bỏ nếu muốn đơn giản)
        $usedColors = Color::whereIn('id', $ids)
            ->whereHas('variants')
            ->pluck('name')
            ->toArray();

        if (!empty($usedColors)) {
            $names = implode(', ', $usedColors);
            return back()->with('error', "Không thể xóa các màu đang sử dụng: $names");
        }

        Color::whereIn('id', $ids)->delete();

        return back()->with('success', 'Đã xóa mềm các màu đã chọn');
    }

    /**
     * Khôi phục hàng loạt (bulk restore)
     */
    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Không có mục nào được chọn');
        }

        Color::withTrashed()->whereIn('id', $ids)->restore();

        return redirect()
            ->route('admin.color.listColor')
            ->with('success', 'Đã khôi phục các màu đã chọn');
    }
}