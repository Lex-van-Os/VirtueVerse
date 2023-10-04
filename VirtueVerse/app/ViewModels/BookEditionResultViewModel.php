<?php

namespace App\ViewModels;

class BookEditionResultViewModel
{
    public $title;
    public $pages;
    public $language;
    public $publicationYear;
    public $isbn;
    public $bookId;
    public $editionsKey;

    public function __construct($title, $pages, $language, $publicationYear, $isbn=null, $bookId=0, $editionsKey=null)
    {
        $this->title = $title;
        $this->pages = $pages;
        $this->language = $language;
        $this->publicationYear = $publicationYear;
        $this->isbn = $isbn;
        $this->bookId = $bookId;
        $this->$editionsKey = $editionsKey;
    }
}