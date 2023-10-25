<?php

namespace App\Observers;
use App\Models\PagesEntry;

class PagesEntryObserver
{
    /**
     * Handle the "creating" event for the Pages Entry model.
     *
     * This method is called when a new pages entry is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the pages entry.
     *
     * @param  PagesEntry  $pagesEntry
     * @return void
     */
    public function creating(PagesEntry $pagesEntry)
    {
        $pagesEntry->created_by = auth()->id();
    }
}
