<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('')->group(function () {

    Route::get('knjige', [PageController::class, 'books'])->name('books');
    Route::get('korpa', [PageController::class, 'cart'])->name('cart');
    Route::get('porudzbina/{order}', [OrderController::class, 'showOrder']);
    Route::get('moje-porudzbine', [PageController::class, 'myOrders']);
    Route::get('knjiga/{id}', [BookController::class, 'getBook']);
});

Route::middleware('admin')->prefix('admin')->group(function () {

    Route::get('/porudzbine', [AdminPageController::class, 'orders']);
    Route::get('knjige', [AdminPageController::class, 'books']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
