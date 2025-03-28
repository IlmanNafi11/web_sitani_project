<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $title;
    public $color;
    public $contentStyle;
    public $titleStyle;

    /**
     * Initial property
     *
     * @param string $title Judul button
     * @param string $color Warna button
     * @param string $contentStyle Style konten button
     */
    public function __construct($title, $color, $contentStyle, $titleStyle)
    {
        $this->title = $title;
        $this->color = $color;
        $this->contentStyle = $contentStyle;
        $this->titleStyle = $titleStyle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.button');
    }
}
