<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class APICustomerController extends Controller
{
    public function register(Request $request)
    {
        Customer::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công!'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu!'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);

        $customer->update([
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Đăng xuất thành công!']);
    }
}
