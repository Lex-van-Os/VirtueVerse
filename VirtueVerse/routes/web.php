<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookEditionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\StudyTrajectoryController;
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


// Routes only accessible for admins
Route::middleware(['auth', 'auth.roles:Admin'])->group(function () {
    
});

// Routes accessible for editors and admins
Route::middleware(['auth', 'auth.roles:Admin,Editor'])->group(function () {

    // Author routes
    Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('author/store', [AuthorController::class, 'store'])->name('author.store')->middleware('web');
    Route::get('book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::put('book/{id}', [BookController::class, 'update'])->name('book.update');
});

Route::post('study-trajectory/store', [StudyTrajectoryController::class, 'store'])->name('study-trajectory.store');
Route::get('study-trajectory/create', [StudyTrajectoryController::class, 'create'])->name('study-trajectory.create');

Route::middleware(['auth', 'can.edit.record'])->group(function () {
    Route::get('book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::put('book/{id}', [BookController::class, 'update'])->name('book.update');
    Route::get('book-edition/edit/{id}', [BookEditionController::class, 'edit'])->name('book-edition.edit');
    Route::put('book-edition/{id}', [BookEditionController::class, 'update'])->name('book-edition.update');
    Route::get('/study-trajectory/{id}', [StudyTrajectoryController::class, 'show'])->name('study-trajectory.show');
    Route::put('/study-trajectory/{id}/{active}', [StudyTrajectoryController::class, 'changeTrajectoryStatus'])->name('study-trajectory.changeTrajectoryStatus');
});

// Routes accessible for users with a user role
Route::middleware(['auth', 'auth.roles:Admin,Editor,User'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book routes
    Route::get('book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('book/store', [BookController::class, 'store'])->name('book.store')->middleware('web');

    // Author routes

    // Book edition routes
    Route::get('book-edition/create', [BookEditionController::class, 'create'])->name('book-edition.create');
    Route::post('book-edition/store', [BookEditionController::class, 'store'])->name('book-edition.store')->middleware('web');
});


// Routes for registration
require __DIR__.'/auth.php';

Route::get('book/catalogue', [BookController::class, 'catalogue'])->name('book.catalogue');
Route::get('/book/search', [BookController::class, 'search'])->name('book.search');
Route::get('book/searchStoredBooks', [BookController::class, 'searchStoredBooks'])->name('book.searchStoredBooks');
Route::get('book/getBookInfo', [BookController::class, 'getBookInfo'])->name('book.getBookInfo');
Route::get('book/getBookImage', [BookController::class, 'getBookImage'])->name('book.getBookImage');
Route::get('book/getBook', [BookController::class, 'getBook'])->name('book.getBook');
Route::get('book/getBookFilterValues', [BookController::class, 'getBookFilterValues'])->name('book.getBookFilterValues');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');
Route::get('book/create', [BookController::class, 'create'])->name('book.create');

Route::get('/author/search', [AuthorController::class, 'search'])->name('author.search');
Route::get('author/getAuthorInfo', [AuthorController::class, 'getAuthorInfo'])->name('author.getAuthorInfo');
Route::get('author/getAuthorFilterValues', [AuthorController::class, 'getAuthorFilterValues'])->name('author.getAuthorFilterValues');

Route::get('/book-edition/getBookEditionImage', [BookEditionController::class, 'getBookEditionImage'])->name('book-edition.getBookEditionImage');
Route::get('/book-edition/search', [BookEditionController::class, 'search'])->name('book-edition.search');
Route::get('/book-edition/getBookEditions', [BookEditionController::class, 'getBookEditions'])->name('book-edition.getBookEditions');
Route::get('book-edition/catalogue', [BookEditionController::class, 'catalogue'])->name('book-edition.catalogue.all');
Route::get('/book-edition/retrieveFilteredItems', [BookEditionController::class, 'retrieveFilteredItems'])->name('book-edition.retrieveFilteredItems');
Route::get('/book-edition/{id}', [BookEditionController::class, 'show'])->name('book-edition.show');
Route::get('book-edition/catalogue/{id}', [BookEditionController::class, 'catalogue'])->name('book-edition.catalogue');
Route::get('/book-edition/getBookEditionById', [BookEditionController::class, 'getBookEditionById'])->name('book-edition.getBookEditionById');

Route::get('/test-database', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});