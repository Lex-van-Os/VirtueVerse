<?php

namespace App\View\Components\books;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BookCard extends Component
{
    public $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.books.book-card');
    }
}
