<?php

namespace App\Http\Controllers;

use App\Models\StudyEntry;
use App\Models\PagesEntry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudyEntryController extends Controller
{
    public function create($study_trajectory_id)
    {
        return view('study-entries.create', compact('study_trajectory_id'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'read-pages' => 'required|integer',
            'notes' => 'nullable|string',
            'study-trajectory-id' => 'required|exists:study_trajectories,id', // Ensure the ID exists in the study_trajectories table
        ]);
    
        // Create a new StudyEntry
        $studyEntry = new StudyEntry();
        $studyEntry->study_trajectory_id = $validatedData['study-trajectory-id'];
        $studyEntry->save();
    
        // Create a new PagesEntry associated with the StudyEntry
        $pagesEntry = new PagesEntry();
        $pagesEntry->study_entry_id = $studyEntry->id; // Link it to the newly created StudyEntry
        $pagesEntry->read_pages = $validatedData['read-pages'];
        $pagesEntry->date = $validatedData['date'];
        $pagesEntry->notes = $validatedData['notes'];
        $pagesEntry->save();

        // $book = Book::create([
        //     'title' => $request->input('title'),
        //     'author' => $request->input('author'),
        //     'publication_year' => $request->input('publication-year'),
        //     'description' => $request->input('description'),
        //     'open_library_key' => $request->input('open-library-key'),
        //     'editions_key' => $editionsKey,
        //     'author_id' => $request->input('author-id')
        // ]);
    
        return redirect()->route('study-trajectory.show', ['id' => $validatedData['study-trajectory-id']])->with('success', 'Study entry created successfully.');
    }
}
