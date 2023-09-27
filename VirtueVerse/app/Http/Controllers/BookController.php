<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\ViewModels\BookResultViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function catalogue()
    {
        $books = Book::all();

        return view('books.catalogue', ['books' => $books]);
    }

    public function show($bookId)
    {
        $book = Book::findOrFail($bookId);

        $author = $book->author;

        return view('books.show', compact('book', 'author'));
    }

    public function create()
    {
        return view('books.create');
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
        Log::info("Store method called");
        Log::info($request);

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer|max:9999',
            'description' => 'required|string',
        ]);

        $openLibraryKey = $request->input('open-library-key');
        $editionsKey = null;

        if ($openLibraryKey != null)
        {
            $editionsKey = $this->getWorksKey($openLibraryKey);
        }

        Log::info($editionsKey);
        Log::info("Creating book");
    
        $book = Book::create([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publication_year' => $request->input('publication_year'),
            'description' => $request->input('description'),
            'open_library_key' => $request->input('open-library-key'),
            'editions_key' => $editionsKey,
            'author_id' => 1 // Placeholder value
        ]);
        
        Log::info("Store method finished");

        return redirect()->route('home')->with('success', 'Book created successfully');
    }

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
