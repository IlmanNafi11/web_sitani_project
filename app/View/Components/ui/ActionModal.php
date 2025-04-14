<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionModal extends Component
{
    public $titleButton;
    public $titleModal;
    /**
     * Create a new component instance.
     */
    public function __construct($titleButton, $titleModal)
    {
        $this->titleButton = $titleButton;
        $this->titleModal = $titleModal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.action-modal');
    }
}
