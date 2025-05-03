<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextArea extends Component
{
    public string $keyId;
    public string $defaultValue;
    public string $name;
    public string $label;
    public string $placeholder;
    public string $helperText;
    public string $extraClassOption;
    public string $extraClassElement;

    /**
     * @param string $keyId id input text area
     * @param string $defaultValue nilai default
     * @param string $name name input text area
     * @param string $label label
     * @param string $placeholder placeholder
     * @param string $helperText helper text
     * @param string $extraClassOption class tailwind tambahan untuk style container input text area
     * @param string $extraClassElement class tailwind tambahan untuk style input text area
     */
    public function __construct(string $keyId = 'input-text-area',
                                string $defaultValue = '',
                                string $name = 'input-text-area',
                                string $label = 'label',
                                string $placeholder = 'placeholder',
                                string $helperText = 'helper text',
                                string $extraClassOption = '',
                                string $extraClassElement = '')
    {
        $this->keyId = $keyId;
        $this->defaultValue = $defaultValue;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->helperText = $helperText;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.text-area');
    }
}
