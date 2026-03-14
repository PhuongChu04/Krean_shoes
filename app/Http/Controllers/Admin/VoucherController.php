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
}
