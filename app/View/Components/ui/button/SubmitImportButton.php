<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitImportButton extends Component
{
    public string $color;
    public string $icon;
    public string $style;
    public string $title;
    public string $formId;
    public string $inputId;
    public string $extraClassElement;
    public string $titleAlert;
    public string $messageAlert;
    public string $titleConfirmButton;
    public string $titleCancelButton;

    /**
     * @param string $color warna button
     * @param string $icon icon button
     * @param string $style style button
     * @param string $title title button
     * @param string $formId id form
     * @param string $inputId id input file
     * @param string $extraClassElement class tailwind custom untuk element, gunakan jika ingin overide style bawaan atau menambahkan style ke element
     * @param string $titleAlert title alert
     * @param string $messageAlert message alert
     * @param string $titleConfirmButton title buttom konfirmasi
     * @param string $titleCancelButton title button cancel
     */
    public function __construct(
        string $color = 'btn-primary',
        string $icon = 'icon-[iconoir--submit-document]',
        string $style = 'btn-soft',
        string $title = 'Import',
        string $formId = '',
        string $inputId = '',
        string $extraClassElement = '',
        string $titleAlert = 'Import Data?',
        string $messageAlert = 'Pastikan Data sudah sesuai dengan aturan yang ditetapkan',
        string $titleConfirmButton = 'Ya',
        string $titleCancelButton = 'Batal')
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->formId = $formId;
        $this->inputId = $inputId;
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
        return view('components.ui.button.submit-import-button');
    }
}
