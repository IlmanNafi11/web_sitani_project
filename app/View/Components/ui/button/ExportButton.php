<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExportButton extends Component
{
    public $title;
    public $style;
    public $icon;
    public $extraClassElement;
    public $color;
    public $routes;
    public $permission;
    public function __construct($title, $style, $icon, $routes, $permission, $color, $extraClassElement)
    {
        $this->title = $title;
        $this->style = $style;
        $this->icon = $icon;
        $this->routes = $routes;
        $this->permission = $permission;
        $this->color = $color;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.export-button');
    }
}
