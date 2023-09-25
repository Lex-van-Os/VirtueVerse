<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\ViewModels\AuthorResultViewModel;
use App\Models\Author;
use Carbon\Carbon;

class AuthorController extends Controller
{
    public function create() 
    {
        return view('authors.create');
    }

    public function store(Request $request) 
    {
        Log::info("Store method called");
        Log::info($request);

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Log::info("Creating book");

        $parsedBirthdate = Carbon::parse($request->input('birthdate'));
    
        $author = Author::create([
            'name' => $request->input('name'),
            'birthdate' => $parsedBirthdate,
            'nationality' => $request->input('nationality'),
            'biography' => $request->input('biography'),
            'open_library_key' => $request->input('open-library-key'),
        ]);
        
        Log::info("Store method finished");

        return redirect()->route('home')->with('success', 'Author created successfully');
    }

    public function filterAuthorSearchResults($searchResults) 
    {
        // Filter out authors with work_count greater than 0
        $filteredResults = array_filter($searchResults['docs'], function ($author) {
            return $author['work_count'] > 0;
        });


        // Sort the filtered authors by work_count in descending order
        usort($filteredResults, function ($a, $b) {
            return $b['work_count'] - $a['work_count'];
        });

        // Re-index after filtering
        $indexedResults = array_values($filteredResults);

        return $indexedResults;
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);
    
        $query = $request->input('query');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/search/authors.json?q=$query&limit=10");

        if ($response->successful()) 
        {
            $searchResults = $response->json();
            $filteredResults = $this->filterAuthorSearchResults($searchResults);

            return response()->json(['results' => $filteredResults]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }

    public function getAuthorInfo(Request $request)
    {
        $request->validate([
            'olid' => 'required|string',
        ]);
    
        $olid = $request->input('olid');

        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/authors/$olid.json");

        Log::info("https://openlibrary.org/authors/$olid.json");

        if ($response->successful()) 
        {
            $authordata = $response->json();

            $name = $authordata['name'];
            $biography = $authordata['bio'] ?? null;
            $birthDate = $authordata['birth_date'] ?? null;
            $openLibraryKey = $olid; // Same value used for sending request

            $authorInfo = new AuthorResultViewModel(
                $name,
                $biography,
                $birthDate,
                $openLibraryKey
            );

            return response()->json(['author' => $authorInfo]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }
}
