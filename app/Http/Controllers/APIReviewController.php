<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class APIReviewController extends Controller
{
    public function create(Request $request)
    {
        Review::updateOrCreate([
            'customer_id' => $request->customer_id,
            'order_detail_id' => $request->order_detail_id,
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
