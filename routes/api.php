<?php

use App\Http\Controllers\APIAuthorController;
use App\Http\Controllers\APIBookController;
use App\Http\Controllers\APICategoryController;
use App\Http\Controllers\APICommentController;
use App\Http\Controllers\APICustomerController;
use App\Http\Controllers\APIOrderController;
use App\Http\Controllers\APIReviewController;
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
Route::post('reset-password', [APICustomerController::class, 'resetPassword'])->name('reset-password');

Route::middleware('auth:api')->group(function () {
    Route::get('me', [APICustomerController::class, 'me'])->name('me');
    Route::post('update', [APICustomerController::class, 'update'])->name('update');
    Route::post('change-password', [APICustomerController::class, 'changePassword'])->name('change-password');
});

Route::prefix('category')->group(function () {
    Route::name('category.')->group(function () {
        Route::get('/', [APICategoryController::class, 'index'])->name('index');
        Route::get('{slug}', [APICategoryController::class, 'getCategoryBySlug'])->name('get-category-by-slug');
    });
});

Route::prefix('author')->group(function () {
    Route::name('author.')->group(function () {
        Route::get('/', [APIAuthorController::class, 'index'])->name('index');
    });
});

Route::prefix('order')->group(function () {
    Route::name('order.')->group(function () {
        Route::get('/', [APIOrderController::class, 'index'])->name('index');
        Route::post('create', [APIOrderController::class, 'create'])->name('create');
        Route::get('details/{id}', [APIOrderController::class, 'details'])->name('details');
        Route::get('confirm/{id}', [APIOrderController::class, 'confirm'])->name('confirm');
        Route::get('cancel/{id}', [APIOrderController::class, 'cancel'])->name('cancel');
    });
});

Route::post('review/create', [APIReviewController::class, 'create'])->name('review.create');

Route::post('comment/create', [APICommentController::class, 'create'])->name('comment.create');
Route::post('comment/reply', [APICommentController::class, 'reply'])->name('comment.reply');
Route::get('comment/get-comments-by-product-id', [APICommentController::class, 'getCommentsByProductId'])->name('comment.get-comments-by-product-id');

Route::get('index', [APIBookController::class, 'index'])->name('index');
Route::get('get-newbooks-and-combos', [APIBookController::class, 'getNewBooksAndCombos'])->name('get-newbooks-and-combos');
Route::get('get-newbooks', [APIBookController::class, 'getNewBooks'])->name('get-newbooks');
Route::get('get-combos', [APIBookController::class, 'getCombos'])->name('get-combos');
Route::get('get-books-by-category/{category_id}', [APIBookController::class, 'getBooksByCategory'])->name('get-books-by-category');
Route::get('search/{slug}', [APIBookController::class, 'search'])->name('search-product');
Route::get('{slug}', [APIBookController::class, 'getProductBySlug'])->name('get-product-by-slug');
