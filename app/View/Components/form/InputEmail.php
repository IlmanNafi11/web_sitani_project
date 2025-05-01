<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputEmail extends Component
{
    public $keyId;
    public $name;
    public $label;
    public $placeholder;
    public $helperText;
    public $extraClassOption;
    public $extraClassElement;
    public $defaultValue;
    public $icon;
    public $isFloatingLabel;

    public function __construct(
        $keyId = null,
        $name = null,
        $label = null,
        $placeholder = null,
        $helperText = null,
        $extraClassOption = '',
        $extraClassElement = '',
        $defaultValue = null,
        $icon = null,
        $isFloatingLabel = false
    )
    {
        $this->keyId = $keyId;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->helperText = $helperText;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->defaultValue = $defaultValue;
        $this->icon = $icon;
        $this->isFloatingLabel = $isFloatingLabel;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-email');
    }
}
