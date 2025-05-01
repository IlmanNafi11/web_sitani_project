<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputText extends Component
{
    public $keyId;
    public $name;
    public $label;
    public $placeholder;
    public $helperText;
    public $extraClassOption;
    public $extraClassElement;
    public $defaultValue;

    public function __construct(
        $keyId = '',
        $name = '',
        $label = '',
        $placeholder = '',
        $helperText = '',
        $extraClassOption = '',
        $extraClassElement = '',
        $defaultValue = null
    ){
        $this->keyId = $keyId;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->helperText = $helperText;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-text');
    }
}
