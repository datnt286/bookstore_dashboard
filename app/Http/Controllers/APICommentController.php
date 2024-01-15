<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class APICommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(
            ['content' => 'required'],
            ['content.required' => 'Vui lòng nhập bình luận.']
        );

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
            'message' => 'Bình luận thành công!',
        ]);
    }

    public function getCommentsByProductId(Request $request)
    {
        $perPage = $request->input('per_page', 5);

        $bookId = $request->input('book_id');
        $comboId = $request->input('combo_id');

        if ($bookId) {
            $comments = Comment::with('customer', 'replies.customer')
                ->where('book_id', $bookId)
                ->whereNull('parent_id')
                ->latest()
                ->paginate($perPage);
        } else if ($comboId) {
            $comments = Comment::with('customer', 'replies.customer')
                ->where('combo_id', $comboId)
                ->whereNull('parent_id')
                ->latest()
                ->paginate($perPage);
        } else {
            $comments = new LengthAwarePaginator([], 0, $perPage);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'comments' => $comments->items(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'total_pages' => $comments->lastPage(),
            ],
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Bình luận không tồn tại!',
            ]);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá bình luận thành công!',
        ]);
    }
}
