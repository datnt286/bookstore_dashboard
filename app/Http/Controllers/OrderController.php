<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $books = Book::all();
        $combos = Combo::all();

        return view('orders.create', compact('books', 'combos'));
    }

    public function store(Request $request)
    {
        $total = 0;

        $order = Order::create([
            'admin_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'total' => $total,
            'status' => 4,
        ]);

        for ($i = 0; $i < count($request->book_id); $i++) {
            OrderDetail::create([
                'order_id' => $order->id,
                'book_id' => $request->book_id[$i],
                'combo_id' => $request->combo_id[$i],
                'price' => $request->price[$i],
                'quantity' => $request->quantity[$i],
            ]);

            $amount = $request->price[$i] * $request->quantity[$i];
            $total += $amount;

            if ($request->book_id[$i]) {
                $book = Book::find($request->book_id[$i]);
                $book->quantity -= $request->quantity[$i];
                $book->save();
            }

            if ($request->combo_id[$i]) {
                $combo = Book::find($request->combo_id[$i]);
                $combo->quantity -= $request->quantity[$i];
                $combo->save();
            }
        }

        Order::find($order->id)
            ->update(['total' => $total]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm hoá đơn thành công!'
        ]);
    }

    public function show($id)
    {
        $orderDetails = OrderDetail::where('order_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $orderDetails
        ]);
    }

    public function updateStatus($id, $status)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại!'
            ]);
        }

        $order->update(['admin_id' => auth()->id(), 'status' => $status]);

        $messages = [
            2 => 'Duyệt đơn thành công!',
            3 => 'Chuyển sang bộ phận vận chuyển thành công!',
            5 => 'Huỷ đơn thành công!',
        ];

        return response()->json([
            'success' => true,
            'message' => $messages[$status]
        ]);
    }
}
