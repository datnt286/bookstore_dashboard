<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use Illuminate\Http\Request;

class APIBookController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 16);

        $books = Book::with('images')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'books' => $books->items(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
                'total_pages' => $books->lastPage(),
            ],
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

    public function getNewBooks(Request $request)
    {
        $perPage = $request->input('per_page', 16);

        $newBooks = Book::with('images')->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'new_books' => $newBooks->items(),
                'per_page' => $newBooks->perPage(),
                'total' => $newBooks->total(),
                'total_pages' => $newBooks->lastPage(),
            ],
        ]);
    }

    public function getCombos(Request $request)
    {
        $perPage = $request->input('per_page', 16);

        $combos = Combo::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'combos' => $combos->items(),
                'per_page' => $combos->perPage(),
                'total' => $combos->total(),
                'total_pages' => $combos->lastPage(),
            ],
        ]);
    }

    public function getProductBySlug($slug)
    {
        $book = Book::with(['authors', 'images', 'combos', 'reviews.customer', 'comments.customer', 'comments.replys'])
            ->where('slug', $slug)
            ->first();
        $combo = Combo::with('reviews.customer', 'comments.customer')
            ->where('slug', $slug)->first();
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

    public function search(Request $request, $keyword)
    {
        $perPage = $request->input('per_page', 16);

        $books = Book::with('images')
            ->where('slug', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);

        $combos = Combo::where('slug', 'LIKE', '%' . $keyword . '%')
            ->paginate($perPage);

        $products = array_merge($books->items(), $combos->items());

        $totalBooks = Book::where('slug', 'LIKE', '%' . $keyword . '%')->count();
        $totalCombos = Combo::where('slug', 'LIKE', '%' . $keyword . '%')->count();
        $totalProducts = $totalBooks + $totalCombos;
        $total_pages = max($books->lastPage(), $combos->lastPage());

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'total' => $totalProducts,
                'per_page' => $perPage,
                'total_pages' => $total_pages,
            ],
        ]);
    }
}
