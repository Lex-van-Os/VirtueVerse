<?php

namespace App\Http\Controllers;

use App\Models\BookEdition;
use App\Http\Controllers\Controller;
use App\ViewModels\BookEditionResultViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookEditionController extends Controller
{
    public function create()
    {
        return view('book-editions.create');
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
            return response()->json(['results' => $searchResults]);
        }
        else
        {
            $errorDetails = $response->json();
            Log::error('API request failed: ' . json_encode($errorDetails));
            return response()->json(['error' => "API request failed."], 500);
        }
    }
}
