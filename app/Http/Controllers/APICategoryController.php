<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class APICategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    public function show($id)
    {
        $category = Category::with('books')->find($id);

        if (empty($category)) {
            return response()->json([
                'success' => false,
                'message' => "Thể loại Id={$id} không tồn tại!"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }

    public function getCategoryBySlug($slug)
    {
        $category = Category::with('books.images')->where('slug', $slug)->first();

        if (empty($category)) {
            return response()->json([
                'success' => false,
                'message' => "Thể loại không tồn tại!"
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }
}
