<?php

namespace App\View\Components\ui\table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderTable extends Component
{
    public array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.table.header-table');
    }
}
