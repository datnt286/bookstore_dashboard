<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();

        if ($request->ajax()) {
            return DataTables::of($customers)
                ->addColumn('action', function ($customer) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $customer->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $customer->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $customer->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('customers.index', compact('customers'));
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $data = [
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        $password = $request->filled('password') ? ['password' => Hash::make($request->password)] : [];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->username . '.' . $extension;

            $file->move(public_path('uploads/customers/'), $fileName);

            $data['avatar'] = $fileName;

            // $customer = Customer::find($id);
            // if ($customer->avatar && Storage::exists('uploads/customers/' . $customer->avatar)) {
            //     Storage::delete('uploads/customers/' . $customer->avatar);
            // }
        }

        $customer = Customer::find($id);
        $customer->update(array_merge($data, $password));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật khách hàng thành công!',
        ]);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá khách hàng thành công!',
        ]);
    }

    public function updateStatus($id)
    {
        $customer = Customer::find($id);

        if ($customer->status == 1) {
            $customer->update(['status' => 0]);
            $message = 'Khoá bình luận tài khoản thành công!';
        } else if ($customer->status == 0) {
            $customer->update(['status' => 1]);
            $message = 'Mở khoá bình luận tài khoản thành công!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $customer,
        ]);
    }
}
