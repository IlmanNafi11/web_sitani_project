<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImportButton extends Component
{
    public $title;
    public $style;
    public $icon;
    public $extraClassElement;
    public $color;
    public $permission;
    public $keyId;
    public function __construct($title, $style, $icon, $permission, $color, $extraClassElement, $keyId)
    {
        $this->title = $title;
        $this->style = $style;
        $this->icon = $icon;
        $this->permission = $permission;
        $this->color = $color;
        $this->extraClassElement = $extraClassElement;
        $this->keyId = $keyId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.import-button');
    }
}
