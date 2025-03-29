<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $dropShadow;
    public $width;
    public $height;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $dropShadow, string $width, string $height)
    {
        $this->dropShadow = $dropShadow;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.card');
    }
}
