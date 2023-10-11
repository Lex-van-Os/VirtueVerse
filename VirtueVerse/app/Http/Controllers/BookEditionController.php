<?php

namespace App\Http\Controllers;

use App\Models\BookEdition;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\ViewModels\BookEditionResultViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookEditionController extends Controller
{
    public function create()
    {
        $books = Book::all();
        Log::info($books);

        return view('book-editions.create', ['books' => $books]);
    }

    public function store(Request $request)
    {
        Log::info("Store method called");
        Log::info($request);

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'pages' => 'required|int',
            'publication-year' => 'required|integer|max:9999',
            'book-id' => 'required|integer'
        ]);

        Log::info("Creating book");
    
        $bookEdition = BookEdition::create([
            'title' => $request->input('title'),
            'isbn' => $request->input('isbn'),
            'publication_year' => $request->input('publication-year'),
            'language' => $request->input('language'),
            'pages' => $request->input('pages'),
            'book_id' => $request->input('book-id'),
        ]);
        
        Log::info("Store method finished");

        return redirect()->route('home')->with('success', 'Book edition created successfully');
    }

    public function search(Request $request)
    {
        
    }

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
}
