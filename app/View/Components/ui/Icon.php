<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public $size;
    public $color;
    public $position;
    /**
     * Create a new component instance.
     */
    public function __construct($size, $color, $position)
    {
        $this->size = $size;
        $this->color = $color;
        $this->position = $position;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.icon');
    }
}
