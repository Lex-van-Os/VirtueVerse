<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

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
})->name('home');;

// Route::get('book/create', 'BookController@create')->name('book.create');
Route::get('book/create', [BookController::class, 'create'])->name('book.create');
Route::get('book/catalogue', [BookController::class, 'catalogue'])->name('book.catalogue');
Route::post('book/store', [BookController::class, 'store'])->name('book.store')->middleware('web');
Route::get('/book/search', [BookController::class, 'search'])->name('book.search');
Route::get('book/getBookInfo', [BookController::class, 'getBookInfo'])->name('book.getBookInfo');

Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('author/store', [AuthorController::class, 'store'])->name('author.store')->middleware('web');
Route::get('/author/search', [AuthorController::class, 'search'])->name('author.search');
Route::get('author/getAuthorInfo', [AuthorController::class, 'getAuthorInfo'])->name('author.getAuthorInfo');

Route::get('book-edition/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('book-edition/store', [AuthorController::class, 'store'])->name('author.store')->middleware('web');
Route::get('/book-edition/search', [AuthorController::class, 'search'])->name('author.search');
Route::get('book-edition/getAuthorInfo', [AuthorController::class, 'getAuthorInfo'])->name('author.getAuthorInfo');

Route::get('/test-database', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});