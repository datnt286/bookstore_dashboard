<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function master()
    {
        if (auth()->check()) {
            return view('index');
        }

        return 'Chưa đăng nhập!';
    }

    public function login()
    {
        return view('admins.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('/')->with(['message' => 'Đăng nhập thành công']);
        }

        return redirect()->route('login')->with(['message' => 'Sai tên đăng nhập hoặc mật khẩu']);
    }

    public function account()
    {
        if (auth()->check()) {
            $admin = auth()->user();

            return view('admins.account', compact('admin'));
        }

        return 'Chưa đăng nhập!';
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function index(Request $request)
    {
        $admins = Admin::all();

        if ($request->ajax()) {
            return DataTables::of($admins)
                ->addColumn('action', function ($admins) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $admins->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $admins->id . '" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $admins->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->input('username') . '.' . $extension;

            $file->move(public_path('uploads/admins/'), $fileName);

            $data['avatar'] = $fileName;
        }

        Admin::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới admin thành công',
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        $password = $request->filled('password') ? ['password' => Hash::make($request->input('password'))] : [];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->input('username') . '.' . $extension;

            $file->move(public_path('uploads/admins/'), $fileName);

            $data['avatar'] = $fileName;

            // $admin = Admin::find($id);
            // if ($admin->avatar && Storage::exists('uploads/admins/' . $admin->avatar)) {
            //     Storage::delete('uploads/admins/' . $admin->avatar);
            // }
        }

        $admin = Admin::find($id);
        $admin->update(array_merge($data, $password));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật admin thành công',
        ]);
    }

    public function updateAccount(Request $request)
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
            $fileName = time() . '_' . $request->input('username') . '.' . $extension;

            $file->move(public_path('uploads/admins/'), $fileName);

            $data['avatar'] = $fileName;

            $admin = Admin::find(auth()->id());
            if ($admin->avatar && Storage::exists($admin->avatar)) {
                Storage::delete($admin->avatar);
            }
        }

        $admin = Admin::find(auth()->id());
        $admin->update($data);

        return redirect()->route('account')->with(['message' => 'Cập nhật thông tin thành công']);
    }

    public function show($id)
    {
        $admin = Admin::find($id);

        return response()->json([
            'success' => true,
            'data' => $admin
        ]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá admin thành công',
        ]);
    }

    public function changePassword(Request $request)
    {
        $admin = Admin::find(auth()->id());
        $admin->update(['password' => Hash::make($request->new_password)]);
    }
}
