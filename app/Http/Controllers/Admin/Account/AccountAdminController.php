<?php

namespace App\Http\Controllers\admin\Account;

use App\Models\User;
use App\Models\Order;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountAdminController extends Controller
{
    public function listAdmins(Request $request)
    {
        $query = User::with('profile')->where('role', 'admin');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $query->whereHas('profile', fn($q) => $q->where('phone', 'like', '%' . $request->phone . '%'));
        }

        if ($request->filled('address')) {
            $query->whereHas('profile', fn($q) => $q->where('address', 'like', '%' . $request->address . '%'));
        }

        if ($request->filled('gender')) {
            $query->whereHas('profile', fn($q) => $q->where('gender', $request->gender));
        }

        // $admins = $query->paginate(100);
        $admins = $query->get();
        // dd($admins);
        return view('admin.account.admin.listAdmins', compact('admins'));
    }
}
