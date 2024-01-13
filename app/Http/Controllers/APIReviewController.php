<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class APIReviewController extends Controller
{
    public function create(Request $request)
    {
        $book_id = $request->input('book_id', null);
        $combo_id = $request->input('combo_id', null);

        Review::updateOrCreate([
            'customer_id' => $request->customer_id,
            'book_id' => $book_id,
            'combo_id' => $combo_id,
        ], [
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá sản phẩm thành công!'
        ]);
    }

    public function getReviewsByProductId(Request $request)
    {
        $bookId = $request->input('book_id');
        $comboId = $request->input('combo_id');

        if ($bookId) {
            $reviews = Review::with('customer')
                ->where('book_id', $bookId)
                ->latest()
                ->get();
        } else if ($comboId) {
            $reviews = Review::with('customer')
                ->where('combo_id', $comboId)
                ->latest()
                ->get();
        } else {
            $reviews = [];
        }

        return response()->json([
            'success' => true,
            'data' => $reviews,
        ]);
    }

    public function checkDelivered(Request $request)
    {
        $customer_id = $request->customer_id;
        $book_id = $request->book_id;
        $combo_id = $request->combo_id;

        $query = Order::where('customer_id', $customer_id);

        if ($book_id) {
            $query->whereHas('order_detail', function ($q) use ($book_id) {
                $q->where('book_id', $book_id);
            });
        } else if ($combo_id) {
            $query->whereHas('order_detail', function ($q) use ($combo_id) {
                $q->where('combo_id', $combo_id);
            });
        }

        $isDelivered = $query->exists();

        return response()->json([
            'success' => true,
            'is_delivered' => $isDelivered,
        ]);
    }
}
