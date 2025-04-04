<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Komponent button edit resource
 */
class ButtonEdit extends Component
{
    public $route;
    public $id;
    public $title;

    /**
     * @param string $route end point form edit resource
     * @param int $id id resource
     * @param string|null $title title button, default 'Ubah'
     */
    public function __construct($route, $id, $title)
    {
        $this->route = $route;
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.button-edit');
    }
}
