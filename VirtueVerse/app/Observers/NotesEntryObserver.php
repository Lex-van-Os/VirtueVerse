<?php

namespace App\Observers;
use App\Models\NotesEntry;

class NotesEntryObserver
{
    /**
     * Handle the "creating" event for the Notes Entry model.
     *
     * This method is called when a new notes entry is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the notes entry.
     *
     * @param  NotesEntry $notesEntry
     * @return void
     */
    public function creating(NotesEntry $notesEntry)
    {
        $notesEntry->created_by = auth()->id();
    }
}
