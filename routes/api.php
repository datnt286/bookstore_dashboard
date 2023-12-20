<?php

use App\Http\Controllers\APIBookController;
use App\Http\Controllers\APICategoryController;
use App\Http\Controllers\APICustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [APICustomerController::class, 'register'])->name('register');
Route::post('login', [APICustomerController::class, 'login'])->name('login');
Route::get('me', [APICustomerController::class, 'me'])->name('me');

Route::prefix('category')->group(function () {
    Route::name('category.')->group(function () {
        Route::get('/', [APICategoryController::class, 'index'])->name('index');
        Route::get('{id}', [APICategoryController::class, 'show'])->name('show');
    });
});

Route::get('index', [APIBookController::class, 'index'])->name('index');
Route::get('get-new-books-and-combos', [APIBookController::class, 'getNewBooksAndCombos'])->name('get-new-books-and-combos');
Route::get('get-books-by-category/{category_id}', [APIBookController::class, 'getBooksByCategory'])->name('get-books-by-category');
Route::get('{slug}', [APIBookController::class, 'getProductBySlug'])->name('get-product-by-slug');
//Route::get('{id}', [APIBookController::class, 'show'])->name('show');
