<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CancelImportButton extends Component
{
    public string $color;
    public string $icon;
    public string $title;
    public string $dataOverlay;
    public string $style;
    public string $labelId;
    public string $inputId;
    public function __construct(
        string $color = 'btn-primary',
        string $icon = '',
        string $title = 'Tutup',
        string $dataOverlay = '',
        string $style = 'btn-soft',
        string $labelId = '',
        string $inputId = '',
    )
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->title = $title;
        $this->dataOverlay = $dataOverlay;
        $this->style = $style;
        $this->labelId = $labelId;
        $this->inputId = $inputId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.cancel-import-button');
    }
}
