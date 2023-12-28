<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();

        if ($request->ajax()) {
            return DataTables::of($customers)
                ->addColumn('action', function ($customers) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $customers->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $customers->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $customers->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        Customer::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới khách hàng thành công!',
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

        $password = $request->filled('password') ? ['password' => Hash::make($request->password)] : [];

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
}
