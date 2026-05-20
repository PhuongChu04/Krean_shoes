<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs for client users.
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('client.faq.index', compact('faqs'));
    }
}
