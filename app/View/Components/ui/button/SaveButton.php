<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SaveButton extends Component
{
    public $color;
    public $icon;
    public $style;
    public $title;
    public $formId;
    public $extraClassElement;
    public $titleAlert;
    public $messageAlert;

    public function __construct(
        $color = 'primary',
        $icon = 'fa-save',
        $style = 'solid',
        $title = 'Simpan',
        $formId = null,
        $extraClassElement = '',
        $titleAlert = 'Konfirmasi Simpan',
        $messageAlert = 'Yakin ingin menyimpan data ini?'
    )
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->formId = $formId;
        $this->extraClassElement = $extraClassElement;
        $this->titleAlert = $titleAlert;
        $this->messageAlert = $messageAlert;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.save-button');
    }
}
