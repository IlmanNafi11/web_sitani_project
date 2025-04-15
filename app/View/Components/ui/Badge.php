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
    public function __construct($color, $style, $title)
    {
        $this->color = $color;
        $this->style = $style;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.badge');
    }
}
