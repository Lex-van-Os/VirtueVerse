<?php

namespace App\ViewModels;

class BookResultViewModel
{
    public $title;
    public $author;
    public $publicationYear;
    public $openLibraryKey;

    public function __construct($title, $author, $publicationYear, $openLibraryKey)
    {
        $this->title = $title;
        $this->author = $author;
        $this->publicationYear = $publicationYear;
        $this->openLibraryKey = $openLibraryKey;
    }
}