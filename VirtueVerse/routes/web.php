<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('book/create', 'BookController@create')->name('book.create');
Route::get('book/create', [BookController::class, 'create'])->name('book.create');
Route::post('book', [BookController::class, 'store'])->name('book.store');
Route::get('/book/search', [BookController::class, 'search'])->name('books.search');
Route::get('book/getBookInfo', [BookController::class, 'getBookInfo'])->name('books.getBookInfo');

Route::get('/test-database', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});