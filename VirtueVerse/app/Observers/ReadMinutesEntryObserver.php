<?php

namespace App\Observers;
use App\Models\ReadMinutesEntry;

class ReadMinutesEntryObserver
{
    /**
     * Handle the "creating" event for the Read Minutes Entry model.
     *
     * This method is called when a new read minutes entry is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the read minutes entry.
     *
     * @param  ReadMinutesEntry  $readMinutesEntry
     * @return void
     */
    public function creating(ReadMinutesEntry $readMinutesEntry)
    {
        $readMinutesEntry->created_by = auth()->id();
    }
}
