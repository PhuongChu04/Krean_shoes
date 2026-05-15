<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\faq\StoreFaqRequest as FaqStoreFaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }
    public function create()
    {
        return view('admin.faq.create');
    }
    public function store(FaqStoreFaqRequest $request)
    {
        Faq::create($request->validated());
        return redirect()->route('admin.account.faqs.index')
            ->with('success', 'Thêm FAQ thành công!');
    }
}
