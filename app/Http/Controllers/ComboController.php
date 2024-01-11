<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComboRequest;
use App\Http\Requests\UpdateComboRequest;
use App\Models\Book;
use App\Models\Combo;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ComboController extends Controller
{
    public function index(Request $request)
    {
        $combos = Combo::all();

        if ($request->ajax()) {
            return DataTables::of($combos)
                ->addColumn('action', function ($combo) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $combo->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $combo->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $combo->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('combos.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => [
                'suppliers' => $suppliers,
                'books' => $books
            ]
        ]);
    }

    public function store(CreateComboRequest $request)
    {
        $combo = Combo::create(
            [
                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
            ],
        );

        $combo->books()->sync($request->book_ids);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $extension;

            $file->move(public_path('uploads/combos/'), $fileName);

            // if ($combo->image && Storage::exists('uploads/combos/' . $combo->image)) {
            //     Storage::delete('uploads/combos/' . $combo->image);
            // }

            $combo->image = $fileName;
            $combo->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới combo thành công!',
        ]);
    }

    public function update(UpdateComboRequest $request)
    {
        $combo = Combo::find($request->id);

        $combo->update(
            [
                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
            ],
        );

        $combo->books()->sync($request->book_ids);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $extension;

            $file->move(public_path('uploads/combos/'), $fileName);

            // if ($combo->image && Storage::exists('uploads/combos/' . $combo->image)) {
            //     Storage::delete('uploads/combos/' . $combo->image);
            // }

            $combo->image = $fileName;
            $combo->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật combo thành công!',
        ]);
    }

    public function edit($id)
    {
        $combo = Combo::with('books')->find($id);
        $suppliers = Supplier::all();
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => [
                'combo' => $combo,
                'suppliers' => $suppliers,
                'books' => $books,
            ],
        ]);
    }

    public function show($id)
    {
        $combo = Combo::with('books')->find($id);

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $combo->name,
                'supplier_id' => $combo->supplier_id,
                'supplier' => $combo->supplier->name,
                'books' => $combo->books,
                'price' => $combo->price,
                'quantity' => $combo->quantity,
                'description' => $combo->description,
                'image' => $combo->image,
            ]
        ]);
    }

    public function destroy($id)
    {
        $combo = Combo::find($id);
        $combo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá combo thành công!',
        ]);
    }

    public function getCombosBySupplier($supplier_id)
    {
        $combos = Combo::where('supplier_id', $supplier_id)->get();

        return response()->json([
            'success' => true,
            'data' => $combos,
        ]);
    }
}
