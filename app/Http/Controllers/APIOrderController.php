<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    public function create(Request $request)
    {
        $total = 0;

        $order = Order::create([
            'customer_id' => $request->user['customer_id'],
            'name' => $request->user['name'],
            'phone' => $request->user['phone'],
            'address' => $request->user['address'],
            'total' => $total,
        ]);

        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'book_id' => $product['book_id'],
                'combo_id' => $product['combo_id'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);

            $amount = $product['price'] * $product['quantity'];
            $total += $amount;

            if ($product['book_id']) {
                $book = Book::find($product['book_id']);
                $book->quantity -= $product['quantity'];
                $book->save();
            }

            if ($product['combo_id']) {
                $combo = Combo::find($product['combo_id']);
                $combo->quantity -= $product['quantity'];
                $combo->save();
            }
        }

        Order::where('id', $order->id)
            ->update([
                'total' => $total,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt hàng thành công!'
        ]);
    }

    public function index()
    {
        $orders = Order::with('order_detail')->get();
        $ordered = Order::where('status', 1)->with('order_detail')->get();
        $confirmed = Order::where('status', 2)->with('order_detail')->get();
        $delivering = Order::where('status', 3)->with('order_detail')->get();
        $delivered = Order::where('status', 4)->with('order_detail')->get();
        $canceled = Order::where('status', 5)->with('order_detail')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'orders' => $orders,
                'ordered' => $ordered,
                'confirmed' => $confirmed,
                'delivering' =>  $delivering,
                'delivered' => $delivered,
                'canceled' =>  $canceled,
            ],
        ]);
    }

    public function details($id)
    {
        $orderDetails = OrderDetail::where('order_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $orderDetails
        ]);
    }

    public function confirm($id)
    {
        $order = Order::find($id);
        $order->update(['status' => 4]);

        return response()->json([
            'success' => true,
            'message' => 'Xác nhận đơn hàng thành công!'
        ]);
    }

    public function cancel($id)
    {
        $order = Order::find($id);
        $order->update(['status' => 5]);

        $orderDetails = OrderDetail::where('order_id', $id)->get();

        foreach ($orderDetails as $orderDetail) {
            if ($orderDetail->book_id) {
                $book = Book::find($orderDetail->book_id);
                $book->quantity += $orderDetail->quantity;
                $book->save();
            }

            if ($orderDetail->combo_id) {
                $combo = Combo::find($orderDetail->combo_id);
                $combo->quantity += $orderDetail->quantity;
                $combo->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Huỷ đơn thành công!'
        ]);
    }
}
