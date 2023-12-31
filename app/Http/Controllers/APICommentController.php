<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Http\Request;

class APICommentController extends Controller
{
    public function create(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if ($customer->status === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn đã bị khoá bình luận!',
            ], 403);
        }

        Comment::create([
            'customer_id' => $request->customer_id,
            'book_id' => $request->book_id,
            'combo_id' => $request->combo_id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bình luận thành công',
        ]);
    }

    public function getCommentsByProductId(Request $request)
    {
        $bookId = $request->input('book_id');
        $comboId = $request->input('combo_id');

        if ($bookId) {
            $comments = Comment::with('customer', 'replys.customer')
                ->where('book_id', $bookId)
                ->whereNull('parent_id')
                ->latest()
                ->get();
        } else if ($comboId) {
            $comments = Comment::with('customer', 'replys.customer')
                ->where('combo_id', $comboId)
                ->whereNull('parent_id')
                ->latest()
                ->get();
        } else {
            $comments = [];
        }

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }
}
