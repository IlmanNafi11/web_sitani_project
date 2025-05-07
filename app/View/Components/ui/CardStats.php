<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardStats extends Component
{
    public string $title;
    public string $stats;
    public string $icon;
    public string $iconColor;

    /**
     * @param string $title Title Card Stats
     * @param string $stats Value stats
     * @param string $icon Icon
     * @param string $iconColor Color Icon
     */
    public function __construct(string $title, string $stats, string $icon, string $iconColor)
    {
        $this->title = $title;
        $this->stats = $stats;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.card-stats');
    }
}
