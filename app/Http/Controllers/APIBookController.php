<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use Illuminate\Http\Request;

class APIBookController extends Controller
{
    public function index()
    {
        $books = Book::with('images')->get();

        return response()->json([
            'success' => true,
            'data' => $books,
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
        $book = Book::with(['authors', 'images', 'combos', 'reviews.customer', 'comments.customer'])
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

    // public function index2(Request $request)
    // {
    //     $perPage = 3; // Số lượng mục trên mỗi trang, mặc định là 10
    //     $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1

    //     $query = Book::query();

    //     // Thêm bất kỳ điều kiện tìm kiếm nào nếu cần

    //     $total = $query->count();
    //     $totalPages = ceil($total / $perPage);

    //     $data = $query->skip(($page - 1) * $perPage)
    //                 ->take($perPage)->with('categories','authors','images')
    //                 ->get();


    //     return response()->json([
    //         'page' => $page,
    //         'per_page' => $perPage,
    //         'total' => $total,
    //         'total_pages' => $totalPages,
    //         'data' => $data,
    //     ]);
    // }
}
