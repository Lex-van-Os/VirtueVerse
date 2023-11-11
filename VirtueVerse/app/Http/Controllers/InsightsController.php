<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StudyTrajectory;
use App\Services\InsightsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InsightsController extends Controller
{
    public function retrieveBookRecommendations($studyTrajectoryId)
    {
        $insightsService = new InsightsApiService();

        $studyTrajectory = StudyTrajectory::with(['bookEdition', 'pagesEntries', 'readMinutesEntries', 'notesEntries'])->findOrFail($studyTrajectoryId);

        $bookRecommendationsData = $insightsService->getBookRecommendations();

        return response()->json($bookRecommendationsData);
    }

    public function retrieveExpectedCompletionTime(Request $request)
    {
        $insightsService = new InsightsApiService();

        $completionTimedata = $insightsService->getExpectedCompletionTime();

        return response()->json($completionTimedata);
    }

    public function retrievePopularBooks(Request $request)
    {
        Log::info("Creating service");
        $insightsService = new InsightsApiService();
        Log::info("Finished creating service");

        $popularBooksData = $insightsService->getPopularBooks();

        return response()->json($popularBooksData);
    }
}

