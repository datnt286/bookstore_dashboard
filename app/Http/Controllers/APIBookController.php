<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class APIBookController extends Controller
{
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
}
