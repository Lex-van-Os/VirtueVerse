<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudyTrajectoryChartController extends Controller
{
    public function checkAvailableCharts()
    {

    }

    // studyTrajectoryId
    public function retrieveReadPagesChartData()
    {
        return response()->json('Foo');
    }
}
