<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public $color;
    public $style;
    public $icon;
    public $title;

    public function __construct(
        $color = 'primary', // Default value
        $style = 'default', // Default value
        $icon = '',         // Default value
        $title = 'Back'     // Default value
    ){
        $this->$color = $color;
        $this->style = $style;
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.back-button');
    }
}
