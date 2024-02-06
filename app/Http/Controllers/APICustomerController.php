<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateCustomerAccountRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class APICustomerController extends Controller
{
    public function register(RegisterRequest $request)
    {
        if ($request->password !== $request->re_enter_password) {
            return response()->json([
                'success' => false,
                'message' => 'Nhập lại mật khẩu không khớp!'
            ], 401);
        }

        Customer::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
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

    public function update(UpdateCustomerAccountRequest $request)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->username . '.' . $extension;

            $file->move(public_path('uploads/customers/'), $fileName);

            $data['avatar'] = $fileName;

            // $customer = Customer::find($request->id);
            // if ($customer->avatar && Customer::exists($customer->avatar)) {
            //     Storage::delete($customer->avatar);
            // }
        }

        $customer = Customer::find($request->id);
        $customer->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $customer = Customer::find($request->id);

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng.'
            ], 401);
        }

        if (!Hash::check($request->old_password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Nhập sai mật khẩu cũ.'
            ], 401);
        }

        if ($request->new_password !== $request->re_enter_password) {
            return response()->json([
                'success' => false,
                'message' => 'Nhập lại mật khẩu không trùng khớp.'
            ], 401);
        }

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

        Mail::send('reset-password.mail', compact('customer', 'newPassword'), function ($email) use ($request) {
            $email->subject('Reset mật khẩu');
            $email->to($request->email);
        });

        return response()->json([
            'success' => true,
            'message' => 'Mật khẩu mới vừa được gửi vào email của bạn. Vui lòng kiểm tra lại email.'
        ]);
    }
}
