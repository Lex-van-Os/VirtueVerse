<?php

namespace App\Observers;
use App\Models\StudyEntry;

class StudyEntryObserver
{
    /**
     * Handle the "creating" event for the Study Entry model.
     *
     * This method is called when a new study entry is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the study entry.
     *
     * @param  StudyEntry $studyEntry
     * @return void
     */
    public function creating(StudyEntry $studyEntry)
    {
        $studyEntry->created_by = auth()->id();
    }
}
