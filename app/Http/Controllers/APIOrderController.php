<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAPIOrderRequest;
use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    public function create(CreateAPIOrderRequest $request)
    {
        foreach ($request->products as $product) {
            if ($product['book_id']) {
                $book = Book::find($product['book_id']);
                if ($product['quantity'] > $book->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Số lượng sản phẩm hiện tại không đủ!'
                    ]);
                }
            }

            if ($product['combo_id']) {
                $combo = Combo::find($product['combo_id']);
                if ($combo['quantity'] > $combo->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Số lượng sản phẩm hiện tại không đủ!'
                    ]);
                }
            }
        }

        $total = 0;
        $totalPayment = 0;

        $order = Order::create([
            'customer_id' => $request->user['customer_id'],
            'name' => $request->user['name'],
            'phone' => $request->user['phone'],
            'address' => $request->user['address'],
            'total' => $total,
            'shipping_fee' => $request->shipping_fee,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
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

        $totalPayment = $total + $request->shipping_fee;

        Order::where('id', $order->id)
            ->update([
                'total' => $total,
                'total_payment' => $totalPayment,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt hàng thành công!'
        ]);
    }

    public function index(Request $request)
    {
        $orders = Order::with('order_details')->where('customer_id', $request->customer_id)->latest()->get();
        $ordered = Order::with('order_details')->where('status', 1)->get();
        $confirmed = Order::with('order_details')->where('status', 2)->get();
        $delivering = Order::with('order_details')->where('status', 3)->get();
        $delivered = Order::with('order_details')->where('status', 4)->get();
        $canceled = Order::with('order_details')->where('status', 5)->get();

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
        $order->update(['status' => 4, 'payment_status' => 1]);

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
