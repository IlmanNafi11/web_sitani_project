<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileInput extends Component
{
    public string $name;
    public string $keyId;
    public string $placeholder;
    public string $helperText;
    public string $extraClassElement;
    public string $accept;

    /**
     * @param string $name attribute name element
     * @param string $keyId attribute id element
     * @param string $placeholder placeholder
     * @param string $helperText helper text(opsional)
     * @param string $extraClassElement class tailwind custom jika ingin overide style bawaan atau menambahkan style
     * @param string $accept filter jenis file yang diperbolehkan
     */
    public function __construct(
        string $name = 'file',
        string $keyId = 'input-file',
        string $placeholder = 'Pilih File',
        string $helperText = 'Upload file',
        string $extraClassElement = '',
        string $accept = '.xlsx, .xls',
    )
    {
        $this->placeholder = $placeholder;
        $this->keyId = $keyId;
        $this->name = $name;
        $this->helperText = $helperText;
        $this->extraClassElement = $extraClassElement;
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.file-input');
    }
}
