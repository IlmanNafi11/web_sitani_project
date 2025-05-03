<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public string $name;
    public string $keyId;
    public string $value;
    public string $defaultValue;
    public string|bool $checked;
    public string $label;
    public string $extraClassOption;
    public string $extraClassElement;
    public string $color;

    /**
     * @param string $name name input radio
     * @param string $value value radio
     * @param string $keyId id input radio
     * @param string $defaultValue nilai default
     * @param string|bool $checked conter checked radio
     * @param string $label label
     * @param string $extraClassOption class tailwind tambahan untuk style kontainer input radio
     * @param string $extraClassElement class tailwind tambahan untuk style input radio
     * @param string $color warna radio
     */
    public function __construct(string $name = 'input-radio',
                                string $value = '',
                                string $keyId = 'input-radio',
                                string $defaultValue = '',
                                string|bool $checked = false,
                                string $label = 'label',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $color = 'radio-primary'
    )
    {
        $this->name = $name;
        $this->value = $value;
        $this->keyId = $keyId;
        $this->defaultValue = $defaultValue;
        $this->checked = $checked;
        $this->label = $label;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.radio');
    }
}
