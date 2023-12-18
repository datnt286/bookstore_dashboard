<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->ajax()) {
            return Datatables::of($categories)
                ->addColumn('action', function ($categories) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $categories->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $categories->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = Category::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $extension;

            $file->move(public_path('uploads/categories/'), $fileName);

            // if ($category->image && Storage::exists('uploads/categories/' . $category->image)) {
            //     Storage::delete('uploads/categories/' . $category->image);
            // }

            $category->image = $fileName;
            $category->save();
        }

        $message = $request->id ? 'Cập nhật' : 'Thêm mới';

        return response()->json([
            'success' => true,
            'message' => $message . ' thể loại thành công',
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá thể loại thành công',
        ]);
    }
}
