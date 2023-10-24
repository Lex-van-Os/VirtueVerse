<?php

namespace App\Observers;
use App\Models\Author;

class AuthorObserver
{
    /**
     * Handle the "creating" event for the Author model.
     *
     * This method is called when a new author is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the author.
     *
     * @param  Author  $author
     * @return void
     */
    public function creating(Author $author)
    {
        $author->created_by = auth()->id();
    }
}
