<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public string $label;
    public array $options;
    public string $optionValue;
    public string $optionLabel;
    public array|string|null $selected;
    public string $helperText;
    public string $placeholder;
    public string $extraClassOption;
    public string $extraClassElement;

    /**
     * @param string $name name input select
     * @param string $label label input select
     * @param array|null $options options
     * @param string $optionValue option value
     * @param string $optionLabel option label
     * @param array|string|null $selected nilai yang terselect
     * @param string $helperText helper text
     * @param string $placeholder placeholder
     * @param string $extraClassOption class tailwind tambahan untuk style container input select
     * @param string $extraClassElement clas tailwind tambahan untuk style input select
     */
    public function __construct(string $name = 'input-select',
                                string $label = 'label',
                                ?array $options = [],
                                string $optionValue = '',
                                string $optionLabel = '',
                                array|string|null $selected = null,
                                string $helperText = 'helper text',
                                string $placeholder = 'placeholder',
                                string $extraClassOption = '',
                                string $extraClassElement = ''
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->selected = $selected;
        $this->helperText = $helperText;
        $this->placeholder = $placeholder;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}
