<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BookEdition;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\ViewModels\BookEditionResultViewModel;
use App\ViewModels\FilterValueViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class BookEditionController extends Controller
{
    /**
     * Display a listing of book editions in the catalogue.
     *
     * @param  int|null  $bookId
     * @return \Illuminate\View\View
     */
    public function catalogue($bookId =  null)
    {
        $bookEditions = $this->getCatalogueItems($bookId, null, null);
        $books = Book::all();

        $bookFilterValues = $books->map(function ($book) {
            return new FilterValueViewModel($book->id, $book->title);
        });

        $authors = Author::all();

        if (is_null($bookId)) 
        {
            $bookId = 0;
        }

        $bookTitle = $bookEditions->isNotEmpty() ? $bookEditions->first()->book->title : '';

        return view('book-editions.catalogue', compact('bookEditions', 'books', 'authors', 'bookId', 'bookTitle'));
    }

    /**
     * Show the form for creating a new book edition.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $books = Book::all();
        Log::info($books);

        return view('book-editions.create', ['books' => $books]);
    }

    /**
     * Show the form for editing an existing book edition.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bookEdition = BookEdition::findOrFail($id);
        $books = Book::all();
    
        return view('book-editions.edit', compact('bookEdition', 'books'));
    }

    /**
     * Display the specified book edition.
     *
     * @param  int  $bookEditionId
     * @return \Illuminate\View\View
     */
    public function show($bookEditionId) 
    {
        $bookEdition = BookEdition::with('book.author')->findOrFail($bookEditionId);

        return view('book-editions.show', compact('bookEdition'));
    }

    /**
     * Store a newly created book edition in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pages' => 'required|int',
            'publication-year' => 'required|integer|max:9999',
            'book-id' => 'required|integer'
        ]);
    
        $bookEdition = BookEdition::create([
            'title' => $request->input('title'),
            'isbn' => $request->input('isbn'),
            'publication_year' => $request->input('publication-year'),
            'language' => $request->input('language'),
            'pages' => $request->input('pages'),
            'book_id' => $request->input('book-id'),
        ]);
        
        return redirect()->route('home')->with('success', 'Book edition created successfully');
    }

    /**
     * Update the specified book edition in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $bookEdition = BookEdition::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'pages' => 'required|int',
            'publication-year' => 'required|integer|max:9999',
            'book-id' => 'required|integer'
        ]);

        $rules = [
            'title' => 'required|string|max:255',
            'pages' => 'required|int',
            'publication-year' => 'required|integer|max:9999',
            'book-id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $bookEdition->title = $request->input('title');
        $bookEdition->pages = $request->input('pages');
        $bookEdition->book_id = $request->input('book-id');
        $bookEdition->publication_year = $request->input('publication-year');

        $bookEdition->update($request->all());

        return redirect()->route('book-edition.show', $bookEdition->id)->with('success', 'Book updated successfully');
    }

    
    /**
     * Search for book editions using the OpenLibrary API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        
    }

    
    /**
     * Retrieve book editions from the database based on filters.
     *
     * @param  int|null  $bookFilter
     * @param  int|null  $authorFilter
     * @param  string|null  $text
     * @return \Illuminate\Support\Collection
     */
    function getCatalogueItems($bookFilter = null, $authorFilter = null, $text = null)
    {
        $query = BookEdition::query();

        // Apply filter on book edition book id if given
        if (!empty($bookFilter)) {
            $query->where('book_id', $bookFilter);
        }

        // Apply filter on book edition -> book -> author if given
        if (!empty($authorFilter)) {
            $query->whereHas('book.author', function ($subquery) use ($authorFilter) {
                $subquery->where('id', $authorFilter);
            });
        }

        // Apply filter on book edition fields through search, if given
        if (!empty($text)) {
            $query->where(function ($subquery) use ($text) {
                $subquery->where('title', 'ilike', "%$text%")
                    ->orWhere('pages', 'ilike', "%$text%")
                    ->orWhere('isbn', 'ilike', "%$text%")
                    ->orWhere('publication_year', 'ilike', "%$text%")
                    ->orWhere('language', 'ilike', "%$text%");
            });
        }

        $bookEditions = $query->get();

        return $bookEditions;
    }

    /**
     * Retrieve filtered book editions based on filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveFilteredItems(Request $request)
    {
        $bookFilter = $request->input('book');
        $authorFilter = $request->input('author');
        $text = $request->input('book-edition');

        $filteredBookEditions = $this->getCatalogueItems($bookFilter, $authorFilter, $text);

        return response()->json(['results' => $filteredBookEditions]);
    }

    /**
     * Format book editions for display.
     *
     * @param  \Illuminate\Support\Collection  $bookEditions
     * @return array
     */
    public function formatBookEditions($bookEditions)
    {
        $editions = [];

        foreach ($bookEditions as $edition)
        {
            $resultViewModel = new BookEditionResultViewModel(
                $title = $edition['title'],
                $pages = $edition['number_of_pages'] ?? null,
                $language = $edition['languages'][0]['key'] ?? null,
                $publicationYear = $edition['publish_date'] ?? null,
                $isbn = $edition['isbn_13'][0] ?? null,
            );
        
            $editions[] = $resultViewModel;
        }

        return $editions;
    }

    /**
     * Get book editions from OpenLibrary by editions key.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookEditions(Request $request)
    {
        $request->validate([
            'editionsKey' => 'required|string',
        ]);
    
        $editionskey = $request->input('editionsKey');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/works/$editionskey/editions.json");

        if ($response->successful()) 
        {
            $searchResults = $response->json();
            $formattedResults = $this->formatBookEditions($searchResults['entries']);

            return response()->json(['results' => $formattedResults]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }

    /**
     * Get book edition by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookEditionById($id)
    {
        $bookEdition = BookEdition::find($id);
    
        if (!$bookEdition) {
            return response()->json(['message' => 'Book edition not found'], 404);
        }
    
        return response()->json(['bookEdition' => $bookEdition], 200);
    }
}
