<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextInput extends Component
{
    public $textLabel;
    public $inputName;
    public $inputPlaceholder;
    public $inputType;
    public $mode;
    public $messageVisible;
    public $errorMessage;

    /**
     * Create a new component instance.
     */
    public function __construct($textLabel, $inputName, $inputPlaceholder, $inputType, $mode, $errorMessage, $messageVisible)
    {
        $this->textLabel = $textLabel;
        $this->inputName = $inputName;
        $this->inputPlaceholder = $inputPlaceholder;
        $this->inputType = $inputType;
        $this->mode = $mode;
        $this->errorMessage = $errorMessage;
        $this->messageVisible = $messageVisible;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.text-input');
    }
}
