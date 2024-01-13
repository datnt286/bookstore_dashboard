<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class APIReviewController extends Controller
{
    public function create(Request $request)
    {
        $book_id = $request->book_id;
        $combo_id = $request->combo_id;

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
}
