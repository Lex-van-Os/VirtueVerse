<?php

namespace App\View\Components\dataControl;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FilterControl extends Component
{
    public $name;
    public $label;
    public $model;

    public function __construct($name, $label, $model)
    {
        $this->name = $name;
        $this->label = $label;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-control.filter-control');
    }
}
