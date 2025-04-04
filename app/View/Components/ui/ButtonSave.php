<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Komponent button save resource
 */
class ButtonSave extends Component
{
    public $title;
    public $formId;

    /**
     * @param string|null $title title button, default 'Simpan'
     * @param mixed $formId id form
     */
    public function __construct($title, $formId)
    {
        $this->title = $title;
        $this->formId = $formId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.button-save');
    }
}
