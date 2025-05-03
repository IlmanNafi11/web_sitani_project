<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputPhone extends Component
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
     * @param string $keyId id input no hp
     * @param string $name name input no hp
     * @param string $label label
     * @param string $placeholder placeholder
     * @param string $helperText helper text
     * @param string $extraClassOption class tailwind tambahan untuk style costom container input no hp
     * @param string $extraClassElement class tailwind tambahan untuk style costom element input no hp
     * @param string $defaultValue default value
     * @param string $icon icon
     */
    public function __construct(string $keyId = 'input-no-hp',
                                string $name = 'input-no-hp',
                                string $label = 'label',
                                string $placeholder = 'placeholder',
                                string $helperText = 'helper text',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $defaultValue = '',
                                string $icon = 'icon-[line-md--email-opened-multiple]',
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
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-phone');
    }
}
