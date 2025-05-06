<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputText extends Component
{
    public string $keyId;
    public string $name;
    public string $label;
    public string $placeholder;
    public string $helperText;
    public string $extraClassOption;
    public string $extraClassElement;
    public string $defaultValue;
    public bool $isDisable;

    /**
     * @param string $keyId id input text
     * @param string $name name input text
     * @param string $label label
     * @param string $placeholder placeholder
     * @param string $helperText helper text
     * @param string $extraClassOption class tailwind tambahan untuk custom style container input text
     * @param string $extraClassElement clas tailwind tambahan untuk custom style input text
     * @param string $defaultValue nilai default
     * @param bool|null $isDisable set true untuk disable, default false
     */
    public function __construct(string $keyId = 'input-text',
                                string $name = 'input-text',
                                string $label = 'label',
                                string $placeholder = 'placeholder',
                                string $helperText = 'helper text',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $defaultValue = '',
                                ?bool $isDisable = false,
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
        $this->isDisable = $isDisable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-text');
    }
}
