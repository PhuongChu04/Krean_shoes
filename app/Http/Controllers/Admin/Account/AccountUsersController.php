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

class AccountUsersController extends Controller
{
    public function listUsers(Request $request)
    {
        $query = User::with('profile') // Eager load profile để tránh N+1
            ->where('role', 'client');   // Lọc role là 'client'

        // Lọc theo name (từ bảng users)
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo email (từ bảng users)
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Lọc theo phone (từ bảng user_profiles)
        if ($request->filled('phone')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->phone . '%');
            });
        }

        // Lọc theo address (từ bảng user_profiles)
        if ($request->filled('address')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('address', 'like', '%' . $request->address . '%');
            });
        }

        // Lọc theo gender (từ bảng user_profiles)
        if ($request->filled('gender')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        // $users = $query->paginate(10); // Phân trang 10 dòng mỗi trang
        $users = $query->withTrashed()->get();
        // dd($Users);
        return view('admin.account.users.listUsers', compact('users'));
    }
}
