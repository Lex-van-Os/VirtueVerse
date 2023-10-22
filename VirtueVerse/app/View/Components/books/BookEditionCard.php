<?php

namespace App\View\Components\books;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BookEditionCard extends Component
{
    public $bookEdition;

    public function __construct($bookEdition)
    {
        $this->bookEdition = $bookEdition;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.books.book-edition-card');
    }
}
