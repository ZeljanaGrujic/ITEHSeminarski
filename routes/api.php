<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', [BookController::class, 'getBooks']);
Route::get('/books-by-ids', [BookController::class, 'getBooksByIds']);
Route::get('/languages', [LanguageController::class, 'getLanguages']);
Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/authors', [AuthorController::class, 'getAuthors']);
Route::get('/order-statuses', [OrderController::class, 'getOrderStatuses']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/my-orders', [OrderController::class, 'getMyOrders']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::get('/orders', [OrderController::class, 'getAllOrders']);
    Route::put('/orders/{order}', [OrderController::class, 'updateOrderStatus']);
    Route::post('/books', [BookController::class, 'createBook']);
    Route::delete('/books/{id}', [BookController::class, 'deleteBook']);
    Route::post('/author', [AuthorController::class, 'createAuthor']);
});
