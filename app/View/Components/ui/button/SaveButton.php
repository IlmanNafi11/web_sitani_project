<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SaveButton extends Component
{
    public $color;
    public $icon;
    public $style;
    public $title;
    public $formId;
    public $extraClassElement;
    public $titleAlert;
    public $messageAlert;
    public $titleConfirmButton;
    public $titleCancelButton;

    public function __construct($color, $icon, $style, $title, $formId, $extraClassElement, $titleAlert, $messageAlert, $titleConfirmButton, $titleCancelButton)
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->formId = $formId;
        $this->extraClassElement = $extraClassElement;
        $this->titleAlert = $titleAlert;
        $this->messageAlert = $messageAlert;
        $this->titleConfirmButton = $titleConfirmButton;
        $this->titleCancelButton = $titleCancelButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.save-button');
    }
}
