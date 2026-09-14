<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BlogController;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "เชื่อมต่อฐานข้อมูลสำเร็จ! Database name: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "ไม่สามารถเชื่อมต่อฐานข้อมูลได้: " . $e->getMessage();
    }
});

Route::get('/', [BlogController::class, 'index']);
Route::get('/detail/{id}', [BlogController::class, 'detail'])->name('detail');

Route::get('/abouts', [AdminController::class, 'about'])->name('abouts');

// Blog Management System Routes (Author)
Route::prefix('author')->group(function () {
    Route::get('/about', [AdminController::class, 'about'])->name('about');
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
    Route::get('/blogs', [AdminController::class, 'blog'])->name('blogs');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/insert', [AdminController::class, 'insert']);
    Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('delete');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
    Route::get('/change/{id}', [AdminController::class, 'change'])->name('change');
});

// Product Management System Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/change/{id}', [ProductController::class, 'changeStatus'])->name('products.change');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
