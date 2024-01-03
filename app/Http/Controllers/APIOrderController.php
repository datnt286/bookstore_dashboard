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
}
