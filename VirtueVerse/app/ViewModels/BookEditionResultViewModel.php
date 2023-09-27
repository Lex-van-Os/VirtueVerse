<?php

namespace App\ViewModels;

class BookEditionResultViewModel
{
    public $title;
    public $pages;

    public function __construct($title, $pages)
    {
        $this->title = $title;
        $this->pages = $pages;
    }
}