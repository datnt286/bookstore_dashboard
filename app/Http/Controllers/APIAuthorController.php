<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class APIAuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            'success' => true,
            'data' => $authors,
        ]);
    }
}
