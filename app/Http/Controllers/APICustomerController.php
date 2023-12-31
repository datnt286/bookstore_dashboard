<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class APICustomerController extends Controller
{
    public function register(Request $request)
    {
        Customer::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công!'
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Sai tên đăng nhập hoặc mật khẩu!'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công!',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
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
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!'
        ]);
    }

    public function changePassword(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Đăng xuất thành công!']);
    }

    public function resetPassword(Request $request)
    {
        $newPassword = Str::random(6);
        $customer = Customer::where('email', $request->email)->first();

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng với địa chỉ email này.'
            ], 404);
        }

        $customer->update(['password' => Hash::make($newPassword)]);

        Mail::send('reset-password.index', compact('customer', 'newPassword'), function ($email) use ($request) {
            $email->subject('Reset mật khẩu');
            $email->to($request->email);
        });

        return response()->json([
            'success' => true,
            'message' => 'Mật khẩu mới vừa được gửi vào email của bạn. Vui lòng kiểm tra lại email.'
        ]);
    }
}
