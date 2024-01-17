<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Combo;
use App\Models\Image;
use App\Models\Publisher;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('images')->get();

        if ($request->ajax()) {
            return DataTables::of($books)
                ->addColumn('image', function ($book) {
                    $image = $book->image;
                    $imageUrl = $image ? asset('uploads/images/' . $image) : asset('img/default-image.jpg');
                    return $imageUrl;
                })
                ->addColumn('action', function ($book) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-info btn-sm btn-detail" data-id="' . $book->id . '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $book->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $book->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('books.index');
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $suppliers = Supplier::all();
        $combos = Combo::all();

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'authors' => $authors,
                'publishers' => $publishers,
                'suppliers' => $suppliers,
                'combos' => $combos,
            ],
        ]);
    }

    public function store(CreateBookRequest $request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'publisher_id' => $request->publisher_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'e_book_price' => $request->e_book_price,
            'language' => $request->language,
            'size' => $request->size,
            'weight' => $request->weight,
            'num_pages' => $request->num_pages,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ];

        $book = Book::create($data);

        $book->authors()->sync($request->author_ids);
        $book->combos()->sync($request->combo_ids);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug($request->name) . '_' . $key . '.' . $extension;
                $file->move(public_path('uploads/images/'), $fileName);

                Image::create([
                    'book_id' => $book->id,
                    'name' => $fileName,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới sách thành công!',
        ]);
    }

    public function update(UpdateBookRequest $request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'publisher_id' => $request->publisher_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'e_book_price' => $request->e_book_price,
            'language' => $request->language,
            'size' => $request->size,
            'weight' => $request->weight,
            'num_pages' => $request->num_pages,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ];

        $book = Book::find($request->id);
        $book->update($data);

        $book->authors()->sync($request->author_ids);
        $book->combos()->sync($request->combo_ids);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug($request->name) . '_' . $key . '.' . $extension;
                $file->move(public_path('uploads/images/'), $fileName);

                Image::create([
                    'book_id' => $book->id,
                    'name' => $fileName,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sách thành công!',
        ]);
    }

    public function edit($id)
    {
        $book = Book::with(['category', 'authors', 'publisher', 'supplier', 'combos', 'images'])->find($id);
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $suppliers = Supplier::all();
        $combos = Combo::all();

        return response()->json([
            'success' => true,
            'data' => [
                'book' => $book,
                'categories' => $categories,
                'authors' => $authors,
                'publishers' => $publishers,
                'suppliers' => $suppliers,
                'combos' => $combos,
                'images' => $book->images,
            ],
        ]);
    }

    public function show($id)
    {
        $book = Book::with('images')->find($id);

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $book->name,
                'category' => $book->category->name,
                'authors' => $book->authors,
                'publisher' => $book->publisher->name,
                'supplier' => $book->supplier->name,
                'size' => $book->size,
                'weight' => $book->weight,
                'num_pages' => $book->num_pages,
                'language' => $book->language,
                'release_date' => $book->release_date,
                'price' => $book->price,
                'e_book_price' => $book->e_book_price,
                'quantity' => $book->quantity,
                'combos' => $book->combos,
                'description' => $book->description,
                'images' => $book->images,
            ],
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá sách thành công!',
        ]);
    }

    public function getBooksBySupplier($supplier_id)
    {
        $books = Book::where('supplier_id', $supplier_id)->get();

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }
}
