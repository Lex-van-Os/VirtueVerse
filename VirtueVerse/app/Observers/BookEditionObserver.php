<?php

namespace App\Observers;
use App\Models\BookEdition;

class BookEditionObserver
{
    /**
     * Handle the "creating" event for the BookEdition model.
     *
     * This method is called when a new book edition is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the book edition.
     *
     * @param  BookEdition  $bookEdition
     * @return void
     */
    public function creating(BookEdition $bookEdition)
    {
        $bookEdition->created_by = auth()->id();
    }
}
