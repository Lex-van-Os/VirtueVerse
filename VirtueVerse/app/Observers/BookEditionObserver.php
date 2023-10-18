<?php

namespace App\Observers;
use App\Models\BookEdition;

class BookEditionObserver
{
    public function creating(BookEdition $bookEdition)
    {
        $bookEdition->created_by = auth()->id();
    }
}
