<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WebInfoController extends Controller
{
    public function show()
    {
        $webInfos = DB::table('web_infos')->pluck('value', 'key');
        return view('admin.webinfor.show', compact('webInfos'));
    }
}
