<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\ViewModels\BookEditionResultViewModel;
use App\ViewModels\BookResultViewModel;
use App\ViewModels\FilterValueViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of all books in the catalogue.
     *
     * @return \Illuminate\View\View
     */
    public function catalogue()
    {
        $books = Book::all();

        return view('books.catalogue', ['books' => $books]);
    }

    /**
     * Display the specified book.
     *
     * @param  int  $bookId
     * @return \Illuminate\View\View
     */
    public function show($bookId)
    {
        $book = Book::with('author', 'editions')->findOrFail($bookId);

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $authors = Author::all();
        return view('books.create', ['authors' => $authors]);
    }

    /**
     * Show the form for editing an existing book.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $authors = Author::all();
        $book = Book::with('author')->findOrFail($id);

        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Get book details by ID from the query parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBook(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['error' => 'Book ID is missing'], 400);
        }

        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book]);
    }

    /**
     * Get the works key for a book from its OpenLibrary key.
     *
     * @param  string  $openLibraryKey
     * @return string|null
     */
    public function getWorksKey($openLibraryKey)
    {
        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/books/$openLibraryKey.json");

        if ($response->successful()) 
        {
            $bookData = $response->json();
            $worksKey = $bookData['works'][0]['key'];
            $worksKeyValue = null;

            $replacePattern = '/\/works\/(\w+)/';

            if (preg_match($replacePattern, $worksKey, $matches)) {
                $worksKeyValue = $matches[1]; 
            } 

            return $worksKeyValue;
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication-year' => 'required|integer|max:9999',
            'description' => 'required|string',
        ]);

        $openLibraryKey = $request->input('open-library-key');
        $editionsKey = null;

        if ($openLibraryKey != null)
        {
            $editionsKey = $this->getWorksKey($openLibraryKey);
        }

        $book = Book::create([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publication_year' => $request->input('publication-year'),
            'description' => $request->input('description'),
            'open_library_key' => $request->input('open-library-key'),
            'editions_key' => $editionsKey,
            'author_id' => $request->input('author-id')
        ]);

        return redirect()->route('home')->with('success', 'Book created successfully');
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication-year' => 'required|integer|max:9999',
            'description' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->author_id = $request->input('author-id');
        $book->publication_year = $request->input('publication-year');

        $book->update($request->all());

        return redirect()->route('book.show', $book->id)->with('success', 'Book updated successfully');
    }

    /**
     * Search for books using the OpenLibrary API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
        
        $query = $request->input('query');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/search.json?q=$query&fields=title,first_publish_year,author_name,edition_key&limit=10&mode=everything");
    
        if ($response->successful()) 
        {
            $searchResults = $response->json();
            return response()->json(['results' => $searchResults]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }

    /**
     * Search for stored books matching the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchStoredBooks(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');

        $queryResults = Book::with('author')
            ->where('title', 'ilike', "%$query%")
            ->take(10)
            ->get();

        $books = [];

        foreach ($queryResults as $book) {
            $resultViewModel = new BookEditionResultViewModel(
                $title = $book->title,
                $pages = $book->pages,
                $language = $book->language,
                $publicationYear = $book->publicationYear,
                $isbn = $book->isbn,
                $bookId = $book->id, // Assuming $book->id represents the bookId
                $editionsKey = $book->editions_key
            );

            $books[] = $book;
        }

        return response()->json(['results' => $books]);
    }

    /**
     * Get detailed information about a book from the OpenLibrary API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookInfo(Request $request)
    {
        $request->validate([
            'olid' => 'required|string',
        ]);

        $olid = $request->input('olid');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/api/books?bibkeys=OLID:$olid&format=json&jscmd=data");

        if ($response->successful()) 
        {
            $bookData = $response->json();

            $title = $bookData["OLID:$olid"]["title"] ?? null;
            $author = $bookData["OLID:$olid"]["authors"][0]["name"] ?? null;
            $publicationYear = $bookData["OLID:$olid"]["publish_date"] ?? null;
            $openLibraryKey = $bookData["OLID:$olid"]["identifiers"]["openlibrary"][0] ?? null;

            $bookInfo = new BookResultViewModel(
                $title,
                $author,
                $publicationYear,
                $openLibraryKey
            );

            return response()->json(['book' => $bookInfo]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }

    /**
     * Get book filter values for use in filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookFilterValues(Request $request) {
        $books = Book::whereHas('editions')->get();

        $bookFilterValues = $books->map(function ($book) {
            return new FilterValueViewModel($book->id, $book->title);
        });

        return response()->json(['bookFilterValues' => $bookFilterValues]);
    }
}
