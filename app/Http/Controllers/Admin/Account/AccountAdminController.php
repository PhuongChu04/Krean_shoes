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

    public function detailAccAdmin($id)
    {
        $admins = User::with([
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
        return view('admin.account.admin.detailAccAdmin', compact('admins'));
    }
    public function editAdmin($id)
    {
        $admins = User::with('profile')->findOrFail($id);
        return view('admin.account.admin.editAdmin', compact('admins'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:client,admin',
            'status' => 'required|in:0,1',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:nam,nu,khac',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admins = User::findOrFail($id);
        $admins->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        $profile = $admins->profile ?? new UserProfile(['user_id' => $admins->id]);
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->gender = $request->gender;

        if ($request->hasFile('user_image')) {
            // Xóa ảnh cũ nếu có
            if ($profile->user_image && Storage::disk('public')->exists($profile->user_image)) {
                Storage::disk('public')->delete($profile->user_image);
            }

            $image = $request->file('user_image');
            $filename = time() . '_' . Str::slug($admins->name) . '.' . $image->getClientOriginalExtension();

            // Lưu ảnh mới
            $path = $image->storeAs('images/users', $filename, 'public');

            // Gán đường dẫn vào DB
            $profile->user_image = $path;
        }

        $admins->profile()->save($profile);

        return redirect()->route('admin.account.listAdmins')->with('success', 'Cập nhật quản trị viên thành công.');
    }
}
