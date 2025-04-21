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

    public function __construct($color, $icon, $style, $title, $route, $extraClassOption, $permission)
    {
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
