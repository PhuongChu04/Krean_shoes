<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Address store request data:', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'ward' => 'required|string|max:100',
                'address' => 'required|string|max:500',
                'type' => 'required|in:home,work,other',
                'is_default' => 'nullable|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Address validation failed:', $e->errors());
            throw $e;
        }

        $user = Auth::user();

        // If setting as default, remove default from other addresses
        if ($request->is_default) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'address' => $request->address,
            'type' => $request->type,
            'is_default' => $request->is_default ?? false,
        ]);

        Log::info('Address created successfully for user:', ['user_id' => $user->id, 'name' => $request->name]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Địa chỉ đã được thêm thành công!']);
        }

        return redirect()->back()->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    public function locationData(Request $request)
    {
        $type = $request->query('type');
        $code = $request->query('code');

        $validTypes = ['province', 'district', 'ward'];
        if (!in_array($type, $validTypes, true)) {
            return response()->json(['error' => 'Loại dữ liệu không hợp lệ'], 400);
        }

        $apiBase = 'https://provinces.open-api.vn/api';
        $endpoint = '';

        switch ($type) {
            case 'province':
                $endpoint = '/p/';
                break;
            case 'district':
                if (empty($code)) {
                    return response()->json(['error' => 'Mã tỉnh bắt buộc'], 400);
                }
                $endpoint = "/p/{$code}?depth=2";
                break;
            case 'ward':
                if (empty($code)) {
                    return response()->json(['error' => 'Mã quận/huyện bắt buộc'], 400);
                }
                $endpoint = "/d/{$code}?depth=2";
                break;
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Accept' => 'application/json', 'User-Agent' => 'Laravel/AddressProxy'])
                ->get($apiBase . $endpoint);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Không thể tải dữ liệu địa chỉ',
                    'status' => $response->status(),
                ], $response->status());
            }

            $data = $response->json();
            $items = [];

            switch ($type) {
                case 'province':
                    $items = array_map(function ($province) {
                        return [
                            'name' => $province['name'] ?? $province['codename'] ?? '',
                            'code' => $province['code'] ?? '',
                        ];
                    }, $data);
                    return response()->json($items);
                case 'district':
                    $districts = $data['districts'] ?? [];
                    $items = array_map(function ($district) {
                        return [
                            'name' => $district['name'] ?? $district['codename'] ?? '',
                            'code' => $district['code'] ?? '',
                        ];
                    }, $districts);
                    return response()->json(['districts' => $items]);
                case 'ward':
                    $wards = $data['wards'] ?? [];
                    $items = array_map(function ($ward) {
                        return [
                            'name' => $ward['name'] ?? $ward['codename'] ?? '',
                            'code' => $ward['code'] ?? '',
                        ];
                    }, $wards);
                    return response()->json(['wards' => $items]);
            }

            return response()->json([]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Lỗi khi tải dữ liệu địa chỉ',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
