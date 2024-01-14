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
        $query = Book::with('images');

        if ($request->has('category_id')) {
            $categoryIds = explode(',', $request->input('category_id'));
            $query->whereIn('category_id', $categoryIds);
        }

        if ($request->has('price_range')) {
            $priceRange = $request->input('price_range');
            switch ($priceRange) {
                case '1':
                    $query->where('price', '<=', 100000);
                    break;
                case '2':
                    $query->whereBetween('price', [100000, 300000]);
                    break;
                case '3':
                    $query->whereBetween('price', [200000, 500000]);
                    break;
                case '4':
                    $query->where('price', '>=', 500000);
                    break;
                default:
            }
        }

        if ($request->has('author_id')) {
            $authorIds = explode(',', $request->input('author_id'));
            $query->whereHas('authors', function ($q) use ($authorIds) {
                $q->whereIn('author_id', $authorIds);
            });
        }

        $books = $query->paginate($perPage);

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
        $book = Book::with(['authors', 'images', 'combos'])
            ->where('slug', $slug)
            ->first();
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

    public function getBooksByCategoryId($category_id)
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

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
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
