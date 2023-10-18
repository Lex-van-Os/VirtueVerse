<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\ViewModels\BookEditionResultViewModel;
use App\ViewModels\BookResultViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function catalogue()
    {
        $books = Book::all();

        return view('books.catalogue', ['books' => $books]);
    }

    public function show($bookId)
    {
        $book = Book::with('author')->findOrFail($bookId);

        return view('books.show', compact('book'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', ['authors' => $authors]);
    }

    public function edit($id)
    {
        $authors = Author::all();
        $book = Book::with('author')->findOrFail($id);
    
        return view('books.edit', compact('book', 'authors'));
    }

    public function getBook(Request $request)
    {
        $id = $request->query('id'); // Retrieve the 'id' query parameter from the request
    
        // Check if 'id' is provided in the query parameters
        if (!$id) {
            return response()->json(['error' => 'Book ID is missing'], 400);
        }
    
        $book = Book::find($id);
    
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    
        return response()->json(['book' => $book]);
    }

    public function getWorksKey($openLibraryKey)
    {
        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/books/$openLibraryKey.json");

        if ($response->successful()) 
        {
            $bookData = $response->json();
            $worksKey = $bookData['works'][0]['key']; // Assuming there's only one work, otherwise, you may iterate through the array
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

    public function store(Request $request)
    {
        // Validate the incoming request data
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

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Validate the incoming request data

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

        // Update the book with the new data
        $book->update($request->all());

        return redirect()->route('book.show', $book->id)->with('success', 'Book updated successfully');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
        
        Log::info("Search query:");
        Log::info($request->input('query'));
        $query = $request->input('query');

        Log::info("Search query:");
        Log::info("https://openlibrary.org/search.json?q=$query&fields=title,first_publish_year,author_name,edition_key&limit=10&mode=everything");
        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/search.json?q=$query&fields=title,first_publish_year,author_name,edition_key&limit=10&mode=everything");
        

        if ($response->successful()) 
        {
            Log::info("Query successful");
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

    // Message is to be used in future re-worked book dropdown upon searching for a book edition
    public function searchStoredBooks(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
    
        $query = $request->input('query');
    
        $queryResults = Book::with('author')
            ->where('title', 'like', "%$query%")
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

    public function getBookInfo(Request $request)
    {
        $request->validate([
            'olid' => 'required|string',
        ]);
    
        $olid = $request->input('olid');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/api/books?bibkeys=OLID:$olid&format=json&jscmd=data");

        Log::info("https://openlibrary.org/books?bibkeys=OLID:$olid&format=json&jscmd=data");

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
}
