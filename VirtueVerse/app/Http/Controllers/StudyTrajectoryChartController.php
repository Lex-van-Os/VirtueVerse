<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudyEntry;
use App\Models\PagesEntry;
use App\Models\NotesEntry;
use App\Models\ReadMinutesEntry;
use App\Models\StudyTrajectory;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StudyTrajectoryChartController extends Controller
{
    public function checkAvailableCharts()
    {

    }

    function retrieveStudyTrajectoryReadpages($studyTrajectoryId) 
    {
        
    }

    // studyTrajectoryId
    // Study trajectory -> entries -> pages
    // Study trajectory -> book
    public function retrieveReadPagesChartData($studyTrajectoryId)
    {
        $studyTrajectory = StudyTrajectory::with(['pagesEntries', 'bookEdition'])->find($studyTrajectoryId);
        $chartData = null;
        $totalPages = null;

        if ($studyTrajectory) 
        {
            $chartData = $studyTrajectory->pagesEntries->sortBy('date');

            $formattedEntries = [];
            $cumulativeValue = 0;

            foreach ($chartData as $pagesEntry) {
                $cumulativeValue += $pagesEntry->read_pages;
                $dateEntry = date("d-m-Y", strtotime($pagesEntry->date));
            
                $formattedEntries[] = [
                    'date' => $dateEntry,
                    'read_pages' => $cumulativeValue,
                ];
            }     
        
            $totalPages = $studyTrajectory->bookEdition->pages;
        }

        if ($chartData && $totalPages) 
        {
            $chartData = [
                'chartData' => $formattedEntries,
                'totalPages' => $totalPages,
            ];

            return response()->json($chartData);
        } 
        else 
        {
            return response()->json([]);
        }
    }

    public function retrievePagesPerMonthChartData($studyTrajectoryId)
    {
        $studyTrajectory = StudyTrajectory::with(['pagesEntries', 'bookEdition'])->find($studyTrajectoryId);
        $monthlyData = null;

        if ($studyTrajectory) 
        {
            $pagesEntries = $studyTrajectory->pagesEntries;

            $monthlyData = $pagesEntries->groupBy(function ($entry) {
                return Carbon::parse($entry->date)->format('F Y');
            })->map(function ($group) {
                return $group->sum('read_pages');
            });
        }

        if ($monthlyData) 
        {
            return response()->json($monthlyData);
        } 
        else 
        {
            return response()->json([]);
        }
    }

    public function retrieveInputtedRecordsChartdata($studyTrajectoryId)
    {
        $pagesEntryCount = PagesEntry::whereHas('studyEntry', function ($query) use ($studyTrajectoryId) {
            $query->where('study_trajectory_id', $studyTrajectoryId);
        })->count();
    
        $notesEntryCount = NotesEntry::whereHas('studyEntry', function ($query) use ($studyTrajectoryId) {
            $query->where('study_trajectory_id', $studyTrajectoryId);
        })->count();
    
        $readMinutesEntryCount = ReadMinutesEntry::whereHas('studyEntry', function ($query) use ($studyTrajectoryId) {
            $query->where('study_trajectory_id', $studyTrajectoryId);
        })->count();
    
        return [
            'pagesEntryCount' => $pagesEntryCount,
            'notesEntryCount' => $notesEntryCount,
            'readMinutesEntryCount' => $readMinutesEntryCount,
        ];
    }

    public function retrieveReadingSpeedChartData($studyTrajectoryId)
    {
        $studyEntries = StudyEntry::with('pagesEntry', 'readMinutesEntry')
            ->where('study_trajectory_id', $studyTrajectoryId)
            ->get();

        if ($studyEntries->isEmpty()) {
            return response()->json(['message' => 'No StudyEntries found for this StudyTrajectory'], 404);
        }

        $correlations = [];
        $highestValue = 0;

        foreach ($studyEntries as $studyEntry) {
            $pagesEntry = $studyEntry->pagesEntry;
            $readMinutesEntry = $studyEntry->readMinutesEntry;

            $correlation = null;
            if ($pagesEntry && $readMinutesEntry) {
                $readPages = $pagesEntry->read_pages;
                $readMinutes = $readMinutesEntry->read_minutes;

                if ($readPages > 0 && $readMinutes > 0) {
                    $correlation = $readPages / $readMinutes;
                    $dateEntry = date("d-m-Y", strtotime($pagesEntry->date));

                    if ($correlation > $highestValue) 
                    {
                        $highestValue = $correlation;
                    }

                    $correlations[] = [
                        'correlation' => $correlation,
                        'date' => $dateEntry
                    ];
                }
            }

        }
        
        return response()->json([
            'correlations' => $correlations,
            'highestValue' => $highestValue
        ]);
    }

    public function retrieveCumulativeReadPages($studyTrajectoryId)
    {

    }
}
