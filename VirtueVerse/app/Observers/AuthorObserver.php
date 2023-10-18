<?php

namespace App\Observers;
use App\Models\Author;

class AuthorObserver
{
    public function creating(Author $author)
    {
        $author->created_by = auth()->id();
    }
}
