<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::whereNull('parent_id')->latest()->get();

        if ($request->ajax()) {
            return DataTables::of($comments)
                ->addColumn('action', function ($comments) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-reply" data-id="' . $comments->id . '"><i class="fas fa-info-circle"></i> Xem phản hồi</button>' .
                        '<button class="btn btn-warning btn-sm mx-1" data-id="' . $comments->customer_id . '"><i class="fas fa-comment-slash"></i> Khoá bình luận</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete mx-1" data-id="' . $comments->id . '"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('comments.index', compact('comments'));
    }

    public function reply($id)
    {
        $replys = Comment::where('parent_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $replys,
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá bình luận thành công!',
        ]);
    }
}
