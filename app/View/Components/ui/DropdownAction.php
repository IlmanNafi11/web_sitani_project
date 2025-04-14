<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class DropdownAction extends Component
{
    public array $items;
    public string $title;
    
    /**
     * Dropdown action button component
     * @param array $items item dropdown(elemen/component)
     * @param string $title title dropdown button, default 'Dropdown'
     */
    public function __construct(array $items, string $title)
    {
        $this->items = $items;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.dropdown-action');
    }
}
