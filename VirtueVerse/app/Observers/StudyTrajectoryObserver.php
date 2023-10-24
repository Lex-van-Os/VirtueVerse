<?php

namespace App\Observers;
use App\Models\StudyTrajectory;

class StudyTrajectoryObserver
{
    /**
     * Handle the "creating" event for the StudyTrajectory model.
     *
     * This method is called when a new study trajectory is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the study trajectory.
     *
     * @param  StudyTrajectory  $studyTrajectory
     * @return void
     */
    public function creating(StudyTrajectory $studyTrajectory)
    {
        $studyTrajectory->created_by = auth()->id();
    }
}
