<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputEmail extends Component
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
    public bool $isFloatingLabel;
    public bool $isDisabled;

    /**
     * @param string $keyId id input email
     * @param string $name name input email
     * @param string $label label
     * @param string $placeholder placeholder
     * @param string $helperText helper text
     * @param string $extraClassOption class tailwind tambahan untuk style costom container input email
     * @param string $extraClassElement class tailwind tambahan untuk style costom element input email
     * @param string $defaultValue default value
     * @param string $icon icon
     * @param ?bool $isFloatingLabel set false jika tidak ingin mode floating, default true
     * @param ?bool $isDisabled set true untuk disable, default false
     */
    public function __construct(string $keyId = 'input-email',
                                string $name = 'input-email',
                                string $label = 'label',
                                string $placeholder = 'placeholder',
                                string $helperText = 'helper text',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $defaultValue = '',
                                string $icon = 'icon-[line-md--phone]',
                                ?bool $isFloatingLabel = true,
                                ?bool $isDisabled = false,
    )
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
        $this->isFloatingLabel = $isFloatingLabel;
        $this->isDisabled = $isDisabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-email');
    }
}
