<?php

namespace App\Observers;
use App\Models\Book;

class BookObserver
{
    /**
     * Handle the "creating" event for the Book model.
     *
     * This method is called when a new book is being created.
     * It assigns the ID of the authenticated user (if available) to the "created_by" attribute of the book.
     *
     * @param  Book  $book
     * @return void
     */
    public function creating(Book $book)
    {
        $book->created_by = auth()->id();
    }
}
