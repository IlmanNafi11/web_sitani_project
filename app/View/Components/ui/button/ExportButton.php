<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Illuminate\View\Component;

class ExportButton extends Component
{
    public string $title;
    public string $style;
    public string $icon;
    public string $extraClassElement;
    public string $color;
    public Route $routes;
    public string $permission;

    /**
     * @param string $title title button
     * @param string $style style button
     * @param string $icon icon button(opsional)
     * @param Route|null $routes route
     * @param string $permission permission
     * @param string $color warna button
     * @param string $extraClassElement class tailwind tambahan untuk custom style button
     */
    public function __construct(string $title = 'Export',
                                string $style = 'btn-soft',
                                string $icon = 'icon-[line-md--file-export]',
                                ?Route $routes = null,
                                string $permission = '',
                                string $color = 'btn-warning',
                                string $extraClassElement = ''
    )
    {
        $this->title = $title;
        $this->style = $style;
        $this->icon = $icon;
        $this->routes = $routes;
        $this->permission = $permission;
        $this->color = $color;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.export-button');
    }
}
