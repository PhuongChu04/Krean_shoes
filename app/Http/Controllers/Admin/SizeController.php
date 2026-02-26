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
}
