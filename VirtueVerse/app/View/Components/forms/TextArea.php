<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TextArea extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $label;
    public $type;

    public function __construct($name, $label, $type = 'text')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.text-input');
    }
}
