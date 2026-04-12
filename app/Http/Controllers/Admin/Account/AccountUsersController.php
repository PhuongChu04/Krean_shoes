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

    public function detailAccUser($id)
    {
        $users = User::with([
            'profile',
            'comments.product' => function ($query) {
                $query->withTrashed()->orderBy('created_at', 'desc');
            },
            'orders.items.product' => function ($query) {
                $query // Eager load quan hệ 'status' (trỏ đến OrderStatus)
                    ->orderBy('created_at', 'desc')
                    ->take(10);
            },
            // Cập nhật ở đây:
            'cartItems.productVariant.product' // Tải CartItem, rồi ProductVariant của nó, rồi Product của ProductVariant đó
        ])
            ->withCount(['orders', 'cartItems'])
            ->findOrFail($id);
        // dd($user);
        return view('admin.account.users.detailAccUser', compact('users'));
    }

    public function softDeleteAdmin($id)
    {
        $admins = User::findOrFail($id);
        $admins->delete();

        return redirect()->back()->with('success', 'Xóa quản trị viên thành công (soft delete).');
    }

    public function trashedAdmins()
    {
        $trashedAdmins = User::onlyTrashed()
            ->where('role', 'admin') // Chỉ lấy tài khoản admin
            ->with('profile')
            ->paginate(10);

        return view('admin.account.admin.trashedAdmins', compact('trashedAdmins'));
    }

    public function restoreAdmin($id)
    {
        $admin = User::withTrashed()->findOrFail($id);
        $admin->restore();

        return redirect()->back()->with('success', 'Khôi phục quản trị viên thành công.');
    }

    public function forceDeleteAdmin($id)
    {
        $admin = User::withTrashed()->findOrFail($id);

        if ($admin->profile) {
            $profile = $admin->profile;

            // Xóa ảnh cũ nếu có
            if ($profile->user_image && Storage::disk('public')->exists($profile->user_image)) {
                Storage::disk('public')->delete($profile->user_image);
            }
            // dd($profile->user_image);

            // Xóa luôn profile (có thể dùng forceDelete nếu có soft deletes)
            $profile->delete(); // hoặc $profile->forceDelete(); nếu model có SoftDeletes
        }

        $admin->forceDelete();

        return redirect()->back()->with('success', 'Xóa quản trị viên vĩnh viễn thành công.');
    }
}
