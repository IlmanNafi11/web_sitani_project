<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordInput extends Component
{
    public string $keyId;
    public string $name;
    public string $label;
    public string $placeholder;
    public string $helperText;
    public string $extraClassOption;
    public string $extraClassElement;
    public string $defaultValue;
    public string $icon;

    /**
     * @param string $keyId id input password
     * @param string $name name input password
     * @param string $label label
     * @param string $placeholder placeholder
     * @param string $helperText helper text
     * @param string $extraClassOption class tailwind tambahan untuk custom style container input password
     * @param string $extraClassElement clas tailwind tambahan untuk custom style input password
     * @param string $defaultValue nilai default
     * @param string $icon icon
     */
    public function __construct(string $keyId = 'input-password',
                                string $name = 'input-password',
                                string $label = 'label',
                                string $placeholder = 'placeholder',
                                string $helperText = 'helper text',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $defaultValue = '',
                                string $icon = 'icon-[solar--lock-password-broken]')
    {
        $this->keyId = $keyId;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->helperText = $helperText;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->defaultValue = $defaultValue;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.password-input');
    }
}
