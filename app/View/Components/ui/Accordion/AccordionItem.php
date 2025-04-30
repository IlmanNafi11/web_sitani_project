<?php

namespace App\View\Components\ui\Accordion;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccordionItem extends Component
{
    public string $title;
    public string $description;
    public string $keyId;

    /**
     * @param string $title Judul
     * @param string $description Deskripsi
     * @param string $keyId Id Items, Wajib untuk control (open/close) item
     */
    public function __construct(string $title, string $description, string $keyId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keyId = $keyId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.accordion.accordion-item');
    }
}
