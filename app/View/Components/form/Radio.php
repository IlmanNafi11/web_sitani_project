<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public $name;
    public $keyId;
    public $value;
    public $defaultValue;
    public $checked;
    public $label;
    public $extraClassOption;
    public $extraClassElement;
    public $color;

    public function __construct($name, $value, $keyId, $defaultValue, $checked, $label, $extraClassOption, $extraClassElement, $color)
    {
        $this->name = $name;
        $this->value = $value;
        $this->keyId = $keyId;
        $this->defaultValue = $defaultValue;
        $this->checked = $checked;
        $this->label = $label;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.radio');
    }
}
