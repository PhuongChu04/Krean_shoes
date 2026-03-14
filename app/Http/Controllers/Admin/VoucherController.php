<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Hiển thị danh sách vouchers không bị xóa
    public function index()
    {
        $vouchers = Voucher::whereNull('deleted_at')->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    // Hiển thị form create
    public function create()
    {
        return view('admin.vouchers.create');
    }

    // Lưu voucher mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:vouchers,code',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'quanlity' => 'required|integer|min:1',
            'discount_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên voucher không được để trống',
            'name.string' => 'Tên voucher phải là chuỗi ký tự',
            'name.max' => 'Tên voucher không được quá 255 ký tự',
            'code.required' => 'Mã voucher không được để trống',
            'code.string' => 'Mã voucher phải là chuỗi ký tự',
            'code.max' => 'Mã voucher không được quá 50 ký tự',
            'code.unique' => 'Mã voucher này đã tồn tại, vui lòng thay đổi tên voucher',
            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'type.required' => 'Loại voucher không được để trống',
            'type.in' => 'Loại voucher phải là percentage hoặc fixed',
            'quanlity.required' => 'Số lượng không được để trống',
            'quanlity.integer' => 'Số lượng phải là số nguyên',
            'quanlity.min' => 'Số lượng phải lớn hơn 0',
            'discount_amount.required' => 'Số tiền giảm giá không được để trống',
            'discount_amount.numeric' => 'Số tiền giảm giá phải là số',
            'discount_amount.min' => 'Số tiền giảm giá phải lớn hơn hoặc bằng 0',
            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ',
            'start_date.before' => 'Ngày bắt đầu phải trước ngày kết thúc',
            'end_date.required' => 'Ngày kết thúc không được để trống',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'status.required' => 'Trạng thái không được để trống',
            'status.in' => 'Trạng thái phải là active hoặc inactive',
        ]);

        // Thêm validation cho discount_amount dựa trên type
        if ($request->type === 'percentage' && $request->discount_amount > 100) {
            return back()->withErrors(['discount_amount' => 'Giảm giá theo phần trăm không được quá 100%'])->withInput();
        }

        Voucher::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'type' => $request->type,
            'quanlity' => $request->quanlity,
            'discount_amount' => $request->discount_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo voucher thành công!');
    }
}
