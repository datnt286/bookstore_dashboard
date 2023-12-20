<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use Illuminate\Http\Request;

class APIBookController extends Controller
{
    public function index()
    {
        $books = Book::with('images')->get()->toArray();
        $combos = Combo::all()->toArray();
        $products = array_merge($books, $combos);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function getNewBooksAndCombos()
    {
        $newBooks = Book::with('images')->latest()->get();
        $combos = Combo::all();

        return response()->json([
            'success' => true,
            'data' => [
                'newBooks' => $newBooks,
                'combos' => $combos,
            ],
        ]);
    }

    public function show($id)
    {
        $book = Book::with('images')->find($id);

        if (empty($book)) {
            return response()->json([
                'success' => false,
                'message' => "Sách Id={$id} không tồn tại"
            ]);
        }

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

    public function getProductBySlug($slug)
    {
        $book = Book::with('images')->where('slug', $slug)->first();
        $combo = Combo::where('slug', $slug)->first();
        $product = $book ? $book : $combo;

        if (empty($product)) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function getBooksByCategory($category_id)
    {
        $books = Book::with('images')->where('category_id', $category_id)->get();

        if (empty($books)) {
            return response()->json([
                'success' => false,
                'message' => 'Danh sách trống!',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }
}
