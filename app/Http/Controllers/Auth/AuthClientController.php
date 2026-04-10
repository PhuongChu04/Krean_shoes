<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthClientController extends Controller
{
 
    public function showDetailAccount()
    {
        $user = Auth::user();
        return view('client.account.detailAccount', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login')->with('message', 'Vui lòng đăng nhập');
        }
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password'  => 'nullable|required_with:password',
            'password'          => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        // Cập nhật thông tin cơ bản
        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Nếu có đổi mật khẩu
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
