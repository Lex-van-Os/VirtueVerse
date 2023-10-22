<?php

namespace App\ViewModels;

class FilterValueViewModel
{
    public $id;
    public $value;

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }
}