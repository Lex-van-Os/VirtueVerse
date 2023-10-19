<?php

namespace App\Observers;
use App\Models\StudyTrajectory;

class StudyTrajectoryObserver
{
    public function creating(StudyTrajectory $studyTrajectory)
    {
        $studyTrajectory->created_by = auth()->id();
    }
}
