<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextArea extends Component
{
    public $keyId;
    public $defaultValue;
    public $name;
    public $label;
    public $placeholder;
    public $helperText;
    public $extraClassOption;
    public $extraClassElement;

    public function __construct($keyId, $defaultValue, $name, $label, $placeholder, $helperText, $extraClassOption, $extraClassElement)
    {
        $this->keyId = $keyId;
        $this->defaultValue = $defaultValue;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->helperText = $helperText;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.text-area');
    }
}
