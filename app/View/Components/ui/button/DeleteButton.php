<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $color;
    public $icon;
    public $style;
    public $title;
    public $route;
    public $keyId;
    public $extraClassOption;
    public $extraClassElement;
    public $permission;

    public function __construct(
        $color = 'danger',          // Default value for color
        $icon = 'trash',            // Default value for icon
        $style = 'default',         // Default value for style
        $title = 'Delete',          // Default value for title
        $route = '',                // Default value for route (optional, can be empty)
        $keyId = null,              // Default value for keyId (optional)
        $extraClassOption = '',     // Default empty class for options
        $extraClassElement = '',    // Default empty class for element
        $permission = null          // Default permission (optional)
    ){
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->route = $route;
        $this->keyId = $keyId;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->permission = $permission;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.delete-button');
    }
}
