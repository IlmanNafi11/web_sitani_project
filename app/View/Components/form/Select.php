<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $options;
    public $optionValue;
    public $optionLabel;
    public $selected;
    public $helperText;
    public $placeholder;
    public $extraClassOption;
    public $extraClassElement;

    public function __construct(
        $name = '',
        $label = '',
        $options = [],
        $optionValue = 'id',
        $optionLabel = 'name',
        $selected = null,
        $helperText = '',
        $placeholder = '',
        $extraClassOption = '',
        $extraClassElement = ''
    ){
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->selected = $selected;
        $this->helperText = $helperText;
        $this->placeholder = $placeholder;
        $this->$extraClassOption = $extraClassOption;
        $this->$extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}
