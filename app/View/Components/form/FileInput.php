<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileInput extends Component
{
    public string $name;
    public string $keyId;
    public string $title;
    public string $helperText;
    public string $extraClassElement;
    public function __construct(string $name, string $keyId, string $title, string $helperText, string $extraClassElement)
    {
        $this->title = $title;
        $this->keyId = $keyId;
        $this->name = $name;
        $this->helperText = $helperText;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.file-input');
    }
}
