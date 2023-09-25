<?php

namespace App\ViewModels;

class AuthorResultViewModel
{
    public $name;
    public $biography;
    public $birthDate;
    public $openLibraryKey;

    public function __construct($name, $biography, $birthDate, $openLibraryKey)
    {
        $this->name = $name;
        $this->biography = $biography;
        $this->birthDate = $birthDate;
        $this->openLibraryKey = $openLibraryKey;
    }
}