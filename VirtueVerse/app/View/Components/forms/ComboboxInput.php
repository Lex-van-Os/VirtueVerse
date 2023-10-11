<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ComboboxInput extends Component
{
    public $name;
    public $label;
    public $models;
    public $idField; // Dynamic attribute for id
    public $valueField; // Dynamic attribute name for combobox value

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $models, $idField, $valueField)
    {
        $this->name = $name;
        $this->label = $label;
        $this->models = $models;
        $this->idField = $idField;
        $this->valueField = $valueField;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.combobox-input');
    }
}