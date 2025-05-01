<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditButton extends Component
{
    public $color;
    public $icon;
    public $style;
    public $title;
    public $route;
    public $extraClassOption;
    public $permission;

    public function __construct(
        $color = 'primary',             // Default value for color
        $icon = 'edit',                 // Default value for icon
        $style = 'default',             // Default value for style
        $title = 'Edit',                // Default value for title
        $route = '',                    // Default value for route (optional, can be empty)
        $extraClassOption = '',         // Default empty class for options
        $permission = null              // Default permission (optional)
    ){
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->route = $route;
        $this->extraClassOption = $extraClassOption;
        $this->permission = $permission;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.edit-button');
    }
}
