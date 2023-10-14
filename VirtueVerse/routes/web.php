<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookEditionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;

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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book routes
    Route::get('book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('book/store', [BookController::class, 'store'])->name('book.store')->middleware('web');

    // Author routes
    Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('author/store', [AuthorController::class, 'store'])->name('author.store')->middleware('web');

    // Book edition routes
    Route::get('book-edition/create', [BookEditionController::class, 'create'])->name('book-edition.create');
    Route::post('book-edition/store', [BookEditionController::class, 'store'])->name('book-edition.store')->middleware('web');
});

// Routes for registration
require __DIR__.'/auth.php';

// Route::get('book/create', 'BookController@create')->name('book.create');
Route::get('book/catalogue', [BookController::class, 'catalogue'])->name('book.catalogue');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');
Route::get('/book/search', [BookController::class, 'search'])->name('book.search');
Route::get('book/searchStoredBooks', [BookController::class, 'searchStoredBooks'])->name('book.searchStoredBooks');
Route::get('book/getBookInfo', [BookController::class, 'getBookInfo'])->name('book.getBookInfo');
Route::get('book/getBook', [BookController::class, 'getBook'])->name('book.getBook');

Route::get('/author/search', [AuthorController::class, 'search'])->name('author.search');
Route::get('author/getAuthorInfo', [AuthorController::class, 'getAuthorInfo'])->name('author.getAuthorInfo');

Route::get('/book-edition/search', [BookEditionController::class, 'search'])->name('book-edition.search');
Route::get('/book-edition/getBookEditions', [BookEditionController::class, 'getBookEditions'])->name('book-edition.getBookEditions');

Route::get('/test-database', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});