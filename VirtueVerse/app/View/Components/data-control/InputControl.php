<?php

namespace App\View\Components\dataControl;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class InputControl extends Component
{
    public $id;
    public $model;
    public $label;

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
        return view('components.data-control.input-control');
    }
}
