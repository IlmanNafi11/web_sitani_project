<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NumberCounter extends Component
{
    public string $label;
    public string $name;
    public string $keyId;
    public string|int $min;
    public string|int $max;
    public string $helperText;
    public string $defaultValue;
    public string $extraClassElement;

    /**
     * @param string $label label
     * @param string $name name input counter
     * @param string $keyId id input counter
     * @param string|int $min nilai minimum
     * @param string|int $max nilai maksimum
     * @param string $helperText helper text
     * @param string|int $defaultValue nilai default
     * @param string $extraClassElement class tailwind tambahan untuk custom style kontainer input counter
     */
    public function __construct(string $label = 'label',
                                string $name = 'number-counter',
                                string $keyId = 'number-counter',
                                string|int $min = 1,
                                string|int $max = 10,
                                string $helperText = 'helper text',
                                string|int $defaultValue = '',
                                string $extraClassElement = ''
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->keyId = $keyId;
        $this->min = $min;
        $this->max = $max;
        $this->helperText = $helperText;
        $this->defaultValue = $defaultValue;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.number-counter');
    }
}
