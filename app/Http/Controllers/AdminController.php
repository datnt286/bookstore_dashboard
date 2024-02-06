<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAdminAccountRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{
    public function stats()
    {
        if (auth()->check()) {
            $totalRevenue = Order::where('status', 4)->sum('total');
            $totalOrders = Order::where('status', 4)->count();
            $totalCustomers = Customer::count();

            $orders = Order::where('status', 4)->get();
            $totalQuantity = 0;
            foreach ($orders as $order) {
                $totalQuantity += $order->order_details->sum('quantity');
            }

            $bestsellers = Book::all()->where('total_quantity_sold_this_month', '>', 0)
                ->sortByDesc('total_quantity_sold_this_month')->take(5);

            return view('stats.index', compact('totalRevenue', 'totalOrders', 'totalCustomers', 'totalQuantity', 'bestsellers'));
        }

        return 'Chưa đăng nhập!';
    }

    public function getMonthlyRevenue()
    {
        $revenueStats = [];

        for ($month = 1; $month <= 6; $month++) {
            $revenueStats["revenueMonth{$month}"] = Order::where('status', 4)
                ->whereYear('created_at', '=', date('Y'))
                ->whereMonth('created_at', '=', $month)
                ->sum('total');
        }

        return response()->json([
            'success' => true,
            'data' => $revenueStats,
        ]);
    }

    public function getRevenueByCategory()
    {
        $currentMonth = now()->month;

        $categories = [
            1 => 'self_helf',
            2 => 'manga',
            3 => 'textbook',
        ];

        $revenues = [];

        foreach ($categories as $categoryId => $categoryName) {
            $revenue = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->join('books', 'order_details.book_id', '=', 'books.id')
                ->where('orders.status', 4)
                ->whereMonth('orders.created_at', $currentMonth)
                ->where('books.category_id', $categoryId)
                ->sum(DB::raw('order_details.price * order_details.quantity'));

            $revenues[$categoryName] = $revenue ?? 0;
        }

        $totalRevenue = Order::where('status', 4)->sum('total');

        $percentages = [];
        foreach ($revenues as $categoryName => $revenue) {
            $percentage = ($totalRevenue != 0) ? round(($revenue / $totalRevenue) * 100, 2) : 0;
            $percentages["revenue_$categoryName"] = $percentage;
        }

        return response()->json([
            'success' => true,
            'data' => $percentages,
        ]);
    }

    public function login()
    {
        return view('admins.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('/')->with(['message' => 'Đăng nhập thành công!']);
        }

        return redirect()->route('login')->with(['message' => 'Sai tên đăng nhập hoặc mật khẩu!']);
    }

    public function account()
    {
        if (auth()->check()) {
            $admin = auth()->user();

            return view('admins.account', compact('admin'));
        }

        return 'Chưa đăng nhập!';
    }

    public function updateAccount(UpdateAdminAccountRequest $request)
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

            $file->move(public_path('uploads/admins/'), $fileName);

            $data['avatar'] = $fileName;

            // $admin = Admin::find(auth()->id());
            // if ($admin->avatar && Storage::exists($admin->avatar)) {
            //     Storage::delete($admin->avatar);
            // }
        }

        $admin = Admin::find(auth()->id());
        $admin->update($data);

        return response()->json([
            'success' => false,
            'message' => 'Cập nhật thông tin thành công!'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $admin = Admin::find(auth()->id());

        if (empty($admin)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy admin.'
            ], 401);
        }

        if (!Hash::check($request->old_password, $admin->password)) {
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

        $admin->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function resetPassword()
    {
        return view('reset-password.index');
    }

    public function handleResetPassword(Request $request)
    {
        if (empty($request->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa nhập email'
            ], 422);
        }

        $newPassword = Str::random(6);
        $admin = Admin::where('email', $request->email)->first();

        if (empty($admin)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng với địa chỉ email này.'
            ], 404);
        }

        $admin->update(['password' => Hash::make($newPassword)]);

        Mail::send('reset-password.mail', compact('admin', 'newPassword'), function ($email) use ($request) {
            $email->subject('Reset mật khẩu');
            $email->to($request->email);
        });

        return response()->json([
            'success' => true,
            'message' => 'Mật khẩu mới vừa được gửi vào email của bạn. Vui lòng kiểm tra lại email.'
        ]);
    }

    public function index(Request $request)
    {
        $admins = Admin::all();

        if ($request->ajax()) {
            return DataTables::of($admins)
                ->addColumn('action', function ($admin) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $admin->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $admin->id . '" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $admin->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('admins.index', compact('admins'));
    }

    public function store(CreateAdminRequest $request)
    {
        $data = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status,
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->username . '.' . $extension;

            $file->move(public_path('uploads/admins/'), $fileName);

            $data['avatar'] = $fileName;
        }

        Admin::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới admin thành công!',
        ]);
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status,
        ];

        $password = $request->filled('password') ? ['password' => Hash::make($request->input('password'))] : [];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $request->username . '.' . $extension;

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
            'message' => 'Cập nhật admin thành công!',
        ]);
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
            'message' => 'Xoá admin thành công!',
        ]);
    }

    public function notFound()
    {
        return view('errors.404');
    }
}
