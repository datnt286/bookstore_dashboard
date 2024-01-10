<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use Illuminate\Http\Request;

class APIBookController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 16;
        $skip = ($page - 1) * $perPage;

        $books = Book::with('images')->skip($skip)->take($perPage)->get();

        $total = Book::count();

        return response()->json([
            'success' => true,
            'data' => $books,
            'total' => $total,
            'per_page' => $perPage,
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
        $page = $request->input('page', 1);
        $perPage = 16;
        $skip = ($page - 1) * $perPage;

        $newBooks = Book::with('images')->latest()
            ->skip($skip)->take($perPage)->get();

        $total = Book::count();

        return response()->json([
            'success' => true,
            'data' => $newBooks,
            'total' => $total,
            'per_page' => $perPage,
        ]);
    }

    public function getCombos(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 16;
        $skip = ($page - 1) * $perPage;

        $combos = Combo::skip($skip)->take($perPage)->get();

        $total = Combo::count();

        return response()->json([
            'success' => true,
            'data' => $combos,
            'total' => $total,
            'per_page' => $perPage,
        ]);
    }

    public function getProductBySlug($slug)
    {
        $book = Book::with(['authors', 'images', 'combos', 'reviews.customer', 'comments.customer', 'comments.replys'])
            ->where('slug', $slug)
            ->first();
        $combo = Combo::with('reviews.customer', 'comments.customer')->where('slug', $slug)->first();
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
        $page = $request->input('page', 1);
        $perPage = 16;
        $skip = ($page - 1) * $perPage;

        $books = Book::with('images')
            ->where('slug', 'LIKE', '%' . $keyword . '%')
            ->skip($skip)
            ->take($perPage)
            ->get();

        $combos = Combo::where('slug', 'LIKE', '%' . $keyword . '%')
            ->skip($skip)
            ->take($perPage)
            ->get();

        $products = array_merge($books->toArray(), $combos->toArray());

        $totalBooks = Book::where('slug', 'LIKE', '%' . $keyword . '%')->count();
        $totalCombos = Combo::where('slug', 'LIKE', '%' . $keyword . '%')->count();
        $totalProducts = $totalBooks + $totalCombos;

        return response()->json([
            'success' => true,
            'data' => $products,
            'total' => $totalProducts,
            'per_page' => $perPage,
        ]);
    }
}
