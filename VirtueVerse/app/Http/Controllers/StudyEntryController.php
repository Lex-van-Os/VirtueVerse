<?php

namespace App\Http\Controllers;

use App\Models\NotesEntry;
use App\Models\ReadMinutesEntry;
use App\Models\StudyEntry;
use App\Models\PagesEntry;
use App\Http\Controllers\Controller;
use App\Rules\StudyEntryFilledFieldRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'read-pages' => 'nullable|integer',
            'notes' => 'nullable|string',
            'reading-time' => 'nullable',
            'study-trajectory-id' => 'required|exists:study_trajectories,id', // Ensure the ID exists in the study_trajectories table
        ]);
        
        $atLeastOneField = !empty($request->input('read-pages')) || !empty($request->input('reading-time')) || !empty($request->input('notes'));

        if (!$atLeastOneField) {
            return redirect()->back()->withInput()->withErrors(['at_least_one_field' => 'At least one of the fields (read pages, reading time, or notes) must be filled.']);
        }

        Log::info("Creating study entry");
        // Create a new StudyEntry
        $studyEntry = new StudyEntry();
        $studyEntry->study_trajectory_id = $validatedData['study-trajectory-id'];
        $studyEntry->save();
    
        $readPages = $request->input('read-pages');
        $readingTime = $request->input('reading-time');
        $notes = $request->input('notes');

        if (isset($readPages)) 
        {
            $this->createPagesEntry($validatedData, $studyEntry->id);
        }

        if (isset($readingTime)) 
        {
            $this->createReadMinutesEntry($validatedData, $studyEntry->id);
        }

        if (isset($notes)) 
        {
            $this->createNotesEntry($request, $studyEntry->id);
        }
    
        return redirect()->route('study-trajectory.show', ['id' => $validatedData['study-trajectory-id']])->with('success', 'Study entry created successfully.');
    }

    public function createPagesEntry($data, $studyEntryId)
    {
        $pagesEntry = new PagesEntry();
        $pagesEntry->study_entry_id = $studyEntryId;
        $pagesEntry->read_pages = $data['read-pages'];
        $pagesEntry->date = $data['date'];
        $pagesEntry->save();
    }

    public function createReadMinutesEntry($data, $studyEntryId)
    {
        $time = $data['reading-time'];
        list($hours, $minutes) = explode(':', $time);
        $totalMinutes = intval($hours) * 60 + intval($minutes);

        $readMinutesEntry = new ReadMinutesEntry();
        $readMinutesEntry->study_entry_id = $studyEntryId;
        $readMinutesEntry->read_minutes = $totalMinutes;
        $readMinutesEntry->date = $data['date'];
        $readMinutesEntry->save();
    }

    public function createNotesEntry($data, $studyEntryId)
    {
        $notesEntry = new NotesEntry();
        $notesEntry->study_entry_id = $studyEntryId;
        $notesEntry->notes = $data['notes'];
        $notesEntry->date = $data['date'];
        $notesEntry->save();
    }

    public function getReadPagesByStudyTrajectory($studyTrajectoryId) 
    {
        $studyTrajectory = StudyTrajectory::with('pagesEntries')->find($studyTrajectoryId);

        if ($studyTrajectory) {
            return $studyTrajectory->pagesEntries;
        }
    
        return [];
    }
}
