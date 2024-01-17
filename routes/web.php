<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GoodsReceviedNoteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'handleLogin'])->name('handle-login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'master'])->name('/');
    Route::get('account', [AdminController::class, 'account'])->name('account');
    Route::post('account', [AdminController::class, 'updateAccount'])->name('update-account');
    Route::post('change-password', [AdminController::class, 'changePassword'])->name('change-password');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('get-monthly-revenue', [AdminController::class, 'getMonthlyRevenue'])->name('get-monthly-revenue');

    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::post('store', [AdminController::class, 'store'])->name('store');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('update');
            Route::get('destroy/{id}', [AdminController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [AdminController::class, 'show'])->name('show');
        });
    });

    Route::prefix('book')->group(function () {
        Route::name('book.')->group(function () {
            Route::get('/', [BookController::class, 'index'])->name('index');
            Route::get('create', [BookController::class, 'create'])->name('create');
            Route::post('store', [BookController::class, 'store'])->name('store');
            Route::get('edit/{id}', [BookController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [BookController::class, 'update'])->name('update');
            Route::get('destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
            Route::get('get-books-by-supplier/{supplier_id}', [BookController::class, 'getBooksBySupplier'])->name('get-books-by-supplier');
            Route::get('{id}', [BookController::class, 'show'])->name('show');
        });
    });

    Route::prefix('combo')->group(function () {
        Route::name('combo.')->group(function () {
            Route::get('/', [ComboController::class, 'index'])->name('index');
            Route::get('create', [ComboController::class, 'create'])->name('create');
            Route::post('store', [ComboController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ComboController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [ComboController::class, 'update'])->name('update');
            Route::get('destroy/{id}', [ComboController::class, 'destroy'])->name('destroy');
            Route::get('get-combos-by-supplier/{supplier_id}', [ComboController::class, 'getCombosBySupplier'])->name('get-combos-by-supplier');
            Route::get('{id}', [ComboController::class, 'show'])->name('show');
        });
    });

    Route::prefix('category')->group(function () {
        Route::name('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [CategoryController::class, 'show'])->name('show');
        });
    });

    Route::prefix('author')->group(function () {
        Route::name('author.')->group(function () {
            Route::get('/', [AuthorController::class, 'index'])->name('index');
            Route::get('create', [AuthorController::class, 'create'])->name('create');
            Route::post('store', [AuthorController::class, 'store'])->name('store');
            Route::get('destroy/{id}', [AuthorController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [AuthorController::class, 'show'])->name('show');
        });
    });

    Route::prefix('publisher')->group(function () {
        Route::name('publisher.')->group(function () {
            Route::get('/', [PublisherController::class, 'index'])->name('index');
            Route::post('store', [PublisherController::class, 'store'])->name('store');
            Route::get('destroy/{id}', [PublisherController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [PublisherController::class, 'show'])->name('show');
        });
    });

    Route::prefix('supplier')->group(function () {
        Route::name('supplier.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::post('store', [SupplierController::class, 'store'])->name('store');
            Route::get('destroy/{id}', [SupplierController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [SupplierController::class, 'show'])->name('show');
        });
    });

    Route::prefix('customer')->group(function () {
        Route::name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::post('store', [CustomerController::class, 'store'])->name('store');
            Route::post('update/{id}', [CustomerController::class, 'update'])->name('update');
            Route::get('update-status/{id}', [CustomerController::class, 'updateStatus'])->name('update-status');
            Route::get('destroy/{id}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [CustomerController::class, 'show'])->name('show');
        });
    });

    Route::prefix('goods-recevied-note')->group(function () {
        Route::name('goods-recevied-note.')->group(function () {
            Route::get('/', [GoodsReceviedNoteController::class, 'index'])->name('index');
            Route::get('create', [GoodsReceviedNoteController::class, 'create'])->name('create');
            Route::post('store', [GoodsReceviedNoteController::class, 'store'])->name('store');
            Route::get('{id}', [GoodsReceviedNoteController::class, 'show'])->name('show');
        });
    });

    Route::prefix('order')->group(function () {
        Route::name('order.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('create', [OrderController::class, 'create'])->name('create');
            Route::post('store', [OrderController::class, 'store'])->name('store');
            Route::get('update-status/{id}/{status}', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::get('{id}', [OrderController::class, 'show'])->name('show');
        });
    });

    Route::prefix('comment')->group(function () {
        Route::name('comment.')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('index');
            Route::get('replies/{id}', [CommentController::class, 'replies'])->name('replies');
            Route::get('destroy/{id}', [CommentController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('slider')->group(function () {
        Route::name('slider.')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index');
            Route::get('create', [SliderController::class, 'create'])->name('create');
            Route::post('store', [SliderController::class, 'store'])->name('store');
            Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SliderController::class, 'update'])->name('update');
            Route::get('destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [SliderController::class, 'show'])->name('show');
        });
    });
});
