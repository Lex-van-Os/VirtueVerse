<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\ViewModels\AuthorResultViewModel;
use App\ViewModels\FilterValueViewModel;
use App\Models\Author;
use Carbon\Carbon;

class AuthorController extends Controller
{
    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\View\View
     */
    public function create() 
    {
        return view('authors.create');
    }

    /**
     * Store a newly created author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) 
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $parsedBirthdate = Carbon::parse($request->input('birthdate'));

        $author = Author::create([
            'name' => $request->input('name'),
            'birthdate' => $parsedBirthdate,
            'nationality' => $request->input('nationality'),
            'biography' => $request->input('biography'),
            'open_library_key' => $request->input('open-library-key'),
        ]);

        return redirect()->route('home')->with('success', 'Author created successfully');
    }

    /**
     * Filter author search results by work count and sort in descending order.
     *
     * @param  array  $searchResults
     * @return array
     */
    public function filterAuthorSearchResults($searchResults) 
    {
        $filteredResults = array_filter($searchResults['docs'], function ($author) {
            return $author['work_count'] > 0;
        });

        usort($filteredResults, function ($a, $b) {
            return $b['work_count'] - $a['work_count'];
        });

        // Re-index after filtering
        $indexedResults = array_values($filteredResults);

        return $indexedResults;
    }

    /**
     * Search for authors using the OpenLibrary API.
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

        // Make an API request to OpenLibrary to search for authors
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

    /**
     * Get detailed information about an author from the OpenLibrary API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthorInfo(Request $request)
    {
        $request->validate([
            'olid' => 'required|string',
        ]);

        $olid = $request->input('olid');

        // Make an API request to OpenLibrary to fetch author information
        $response = Http::withOptions(['verify' => false])->get("https://openlibrary.org/authors/$olid.json");

        if ($response->successful()) 
        {
            $authordata = $response->json();

            $name = $authordata['name'];
            $biography = $authordata['bio'] ?? null;
            $birthDate = $authordata['birth_date'] ?? null;
            $openLibraryKey = $olid; // Same value used for sending the request

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

    /**
     * Get a list of authors for use in filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthorFilterValues(Request $request) {
        $authors = Author::whereHas('books.editions')->get();

        $authorFilterValues = $authors->map(function ($author) {
            return new FilterValueViewModel($author->id, $author->name);
        });

        return response()->json(['authorFilterValues' => $authorFilterValues]);
    }
}
