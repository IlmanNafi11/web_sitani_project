<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SaveButton extends Component
{
    public string $color;
    public string $icon;
    public string $style;
    public string $title;
    public string $formId;
    public string $extraClassElement;
    public string $titleAlert;
    public string $messageAlert;
    public string $titleConfirmButton;
    public string $titleCancelButton;

    /**
     * @param string $color warna button
     * @param string $icon icon button(opsional)
     * @param string $style style button
     * @param string $title title button
     * @param string $formId form id yang akan disubmit
     * @param string $extraClassElement class tailwind tambahan untuk style custom button
     * @param string $titleAlert title sweet alert
     * @param string $messageAlert description sweet alert
     * @param string $titleConfirmButton title button confirm
     * @param string $titleCancelButton title button cancel
     */
    public function __construct(string $color = 'btn-accent',
                                string $icon = 'icon-[fluent--document-save-24-regular]',
                                string $style = 'btn-soft',
                                string $title = 'Simpan',
                                string $formId = 'form',
                                string $extraClassElement = '',
                                string $titleAlert = 'Simpan data?',
                                string $messageAlert = 'Pastikan data telah valid!',
                                string $titleConfirmButton = 'Simpan',
                                string $titleCancelButton = 'Batal',
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
        $this->titleConfirmButton = $titleConfirmButton;
        $this->titleCancelButton = $titleCancelButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.save-button');
    }
}
