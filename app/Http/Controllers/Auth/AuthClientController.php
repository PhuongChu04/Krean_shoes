<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AuthClientController extends Controller
{
 
   public function showDetailAccount()
{
    $user = Auth::user();

    $userProfile = $user->userProfile()->firstOrCreate(
        ['user_id' => $user->id],
        [
            'phone'      => null,
            'address'    => null,
            'gender'     => 'khac',
            'birth_date' => null,
            'user_image' => null,
        ]
    );

    return view('client.account.detailAccount', compact('user', 'userProfile'));
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
            'phone'             => 'nullable|string|max:20',
            'address'           => 'nullable|string|max:500',
            'gender'            => 'nullable|in:nam,nu,khac',
            'birth_date'        => 'nullable|date|before:today',
            'user_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        // Cập nhật UserProfile
        $userProfile = $user->userProfile ?? $user->userProfile()->create([]);
        
        // Xử lý upload ảnh đại diện
        $profileData = [
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'gender'     => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ];
        
        if ($request->hasFile('user_image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($userProfile->user_image && Storage::exists($userProfile->user_image)) {
                Storage::delete($userProfile->user_image);
            }
            
            // Upload ảnh mới
            $imagePath = $request->file('user_image')->store('user-avatars', 'public');
            $profileData['user_image'] = $imagePath;
        }
        
        $userProfile->update($profileData);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
