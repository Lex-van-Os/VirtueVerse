<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ViewModels\BookResultViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'pages' => 'required|integer|min:1',
            'publication_year' => 'required|integer|min:1000|max:9999',
            'language' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // Create a new book record in the database using the validated data
        $book = new Book([
            'title' => $request->input('title'),
            'pages' => $request->input('pages'),
            'publication_year' => $request->input('publication_year'),
            'language' => $request->input('language'),
            'description' => $request->input('description'),
        ]);
    
        // Save the new book record
        $book->save();
    
        // Redirect to a success page or return a response as needed
        return redirect()->route('book.index')->with('success', 'Book created successfully');
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
            Log::info($bookData);

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
