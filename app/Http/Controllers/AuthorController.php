<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::all();

        if ($request->ajax()) {
            return DataTables::of($authors)
                ->addColumn('action', function ($authors) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $authors->id . '" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $authors->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );

        $author->books()->sync($request->book_ids);

        $message = $request->id ? 'Cập nhật' : 'Thêm mới';

        return response()->json([
            'success' => true,
            'message' => $message . ' tác giả thành công!',
        ]);
    }

    public function show($id)
    {
        $author = Author::with(['books'])->find($id);
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => [
                'author' => $author,
                'books' => $books,
            ],
        ]);
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá tác giả thành công!',
        ]);
    }
}
