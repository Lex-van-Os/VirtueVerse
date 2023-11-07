<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudyEntry;
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

    public function retrieveCumulativeReadPages($studyTrajectoryId)
    {

    }
}
