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
    /**
     * Show the form for creating a new study trajectory.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $bookEditions = BookEdition::all();
        return view('study-trajectories.create', compact('bookEditions'));
    }

    /**
     * Display the specified study trajectory.
     *
     * @param  int  $studyTrajectoryId
     * @return \Illuminate\View\View
     */
    public function show($studyTrajectoryId) 
    {
        $studyTrajectory = StudyTrajectory::with('bookEdition')->findOrFail($studyTrajectoryId);

        return view('study-trajectories.show', compact('studyTrajectory'));
    }

    /**
     * Display a listing of all owned study trajectories.
     *
     * @return \Illuminate\View\View
     */
    public function catalogue($userId)
    {
        $studyTrajectories = StudyTrajectory::where('created_by', $userId)->get();

        return view('study-trajectories.catalogue', ['studyTrajectories' => $studyTrajectories]);
    }

    /**
     * Store a newly created study trajectory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect('/')->with('success', 'Study trajectory created successfully');
    }

    /**
     * Change the status of a study trajectory.
     *
     * @param  int  $id
     * @param  boolean  $active
     * @return \Illuminate\View\View
     */
    public function changeTrajectoryStatus($id, $active)
    {
        $studyTrajectory = StudyTrajectory::findOrFail($id);

        $studyTrajectory->update(['active' => $active]);
        
        $studyTrajectory = StudyTrajectory::with('bookEdition')->findOrFail($id);
    
        return view('study-trajectories.show', compact('studyTrajectory'));
    }
}




