<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public $color;
    public $style;
    public $icon;
    public $title;
    public $routes;

    public function __construct($color, $style, $icon, $title, $routes)
    {
        $this->color = $color;
        $this->style = $style;
        $this->icon = $icon;
        $this->title = $title;
        $this->routes = $routes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.back-button');
    }
}
