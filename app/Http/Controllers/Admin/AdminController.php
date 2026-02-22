<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
     public function homeAdmin()
    {
        return view('admin.homeAdmin');
    }


     public function listCate()
    {
        return view('admin.category.listCategory');
    }
     public function listProduct()
    {
        return view('admin.products.listProduct');
    }
}
