<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public string $title;
    public string $keyId;
    public string $positions;
    public string $isStatic;
    public string $overlayBackdropColor;
    public function __construct(string $title, string $keyId, string $positions, bool $isStatic, string $overlayBackdropColor)
    {
        $this->title = $title;
        $this->keyId = $keyId;
        $this->positions = $positions;
        $this->isStatic = $isStatic;
        $this->overlayBackdropColor = $overlayBackdropColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.modal');
    }
}
