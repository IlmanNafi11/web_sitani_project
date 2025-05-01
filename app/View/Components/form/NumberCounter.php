<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NumberCounter extends Component
{
    public $label;
    public $name;
    public $keyId;
    public $min;
    public $max;
    public $helperText;
    public $defaultValue;
    public $extraClassElement;

    public function __construct(
        $label = '',
        $name = '',
        $keyId = '',
        $min = 0,
        $max = 100,
        $helperText = '',
        $defaultValue = 0,
        $extraClassElement = ''
    ){
        $this->label = $label;
        $this->name = $name;
        $this->keyId = $keyId;
        $this->min = $min;
        $this->max = $max;
        $this->helperText = $helperText;
        $this->defaultValue = $defaultValue;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.number-counter');
    }
}
