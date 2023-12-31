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

    public function getNewBooks()
    {
        $newBooks = Book::with('images')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $newBooks,
        ]);
    }

    public function getCombos()
    {
        $combos = Combo::all();

        return response()->json([
            'success' => true,
            'data' => $combos,
        ]);
    }

    public function getProductBySlug($slug)
    {
        $book = Book::with('images')->with('combos')->with('category')->with('authors')->where('slug', $slug)->first();
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

    public function search($slug)
    {
        $books = Book::with('images')->where('slug', 'LIKE', '%' . $slug . '%')->get()->toArray();
        $combos = Combo::where('slug', 'LIKE', '%' . $slug . '%')->get()->toArray();
        $products = array_merge($books, $combos);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
