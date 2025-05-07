<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public $color;
    public $style;
    public $title;
    public $icon;

    public function __construct($color, $style, $title, $icon)
    {
        $this->color = $color;
        $this->style = $style;
        $this->title = $title;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.badge');
    }
}
