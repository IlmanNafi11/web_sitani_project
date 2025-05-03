<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public string $color;
    public string $style;
    public string $icon;
    public string $title;
    public string $routes;

    /**
     * @param string $color warna button
     * @param string $style style button
     * @param string $icon icon button(opsional)
     * @param string $title title button
     * @param string|null $routes route
     */
    public function __construct(string $color = 'btn-secondary',
                                string $style = 'btn-soft',
                                string $icon = 'icon-[material-symbols--arrow-back-ios-rounded]',
                                string $title = 'Kembali',
                                ?string $routes = null)
    {
        $this->color = $color;
        $this->style = $style;
        $this->icon = $icon;
        $this->title = $title;
        $this->routes = $routes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.back-button');
    }
}
