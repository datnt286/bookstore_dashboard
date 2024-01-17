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

Route::post('register', [APICustomerController::class, 'register']);
Route::post('login', [APICustomerController::class, 'login']);
Route::post('reset-password', [APICustomerController::class, 'resetPassword']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [APICustomerController::class, 'me']);
    Route::post('update', [APICustomerController::class, 'update']);
    Route::post('change-password', [APICustomerController::class, 'changePassword']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [APICategoryController::class, 'index']);
    Route::get('{slug}', [APICategoryController::class, 'getCategoryBySlug']);
});

Route::prefix('author')->group(function () {
    Route::get('/', [APIAuthorController::class, 'index']);
});

Route::prefix('order')->group(function () {
    Route::get('/', [APIOrderController::class, 'index']);
    Route::post('create', [APIOrderController::class, 'create']);
    Route::get('details/{id}', [APIOrderController::class, 'details']);
    Route::get('confirm/{id}', [APIOrderController::class, 'confirm']);
    Route::get('cancel/{id}', [APIOrderController::class, 'cancel']);
});

Route::prefix('review')->group(function () {
    Route::post('create', [APIReviewController::class, 'create']);
    Route::get('reviews-by-product-id', [APIReviewController::class, 'getReviewsByProductId']);
    Route::get('check-delivered', [APIReviewController::class, 'checkDelivered']);
});

Route::prefix('comment')->group(function () {
    Route::post('create', [APICommentController::class, 'create']);
    Route::get('comments-by-product-id', [APICommentController::class, 'getCommentsByProductId']);
    Route::get('destroy/{id}', [APICommentController::class, 'destroy']);
});

Route::get('home', [APIBookController::class, 'home']);
Route::get('newbooks', [APIBookController::class, 'getNewBooks']);
Route::get('bestsellers', [APIBookController::class, 'getBestsellers']);
Route::get('combos', [APIBookController::class, 'getCombos']);
Route::get('books-by-category-id/{category_id}', [APIBookController::class, 'getBooksByCategoryId']);
Route::get('store', [APIBookController::class, 'store']);
Route::get('search', [APIBookController::class, 'search']);
Route::get('{slug}', [APIBookController::class, 'getProductBySlug']);
