<?php

namespace App\Http\Controllers;

use App\Models\BookEdition;
use Illuminate\Http\Request;
use App\Models\StudyTrajectory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudyTrajectoryController extends Controller
{
    public function create()
    {
        $bookEditions = BookEdition::all();
        return view('study-trajectories.create', compact('bookEditions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'book-edition' => 'required',
        ]);

        StudyTrajectory::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'active' => $request->input('active', true),
            'book_edition_id' => $request->input('book-edition-id')
        ]);

        return redirect()->route('home')->with('success', 'Study trajectory created successfully');
    }
}




