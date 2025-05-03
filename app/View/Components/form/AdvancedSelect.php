<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdvancedSelect extends Component
{
    public string $keyId;
    public string $label;
    public string $name;
    public string $placeholder;
    public array|null $options;
    public string $optionValue;
    public string $optionLabel;
    public array|string|null $selected;
    public string $helperText;
    public string $extraClassOptions;
    public string $extraClassElement;
    public bool $isMultiple;
    public bool $hasSearch;
    public string $searchPlaceholder;
    public string $noResultText;

    /**
     * @param string $keyId id select
     * @param string $label label select
     * @param string $name name select
     * @param string $placeholder placeholder
     * @param array|null $options options select
     * @param string|null $optionValue options value
     * @param string|null $optionLabel options label
     * @param array|string|null $selected option yang terselect
     * @param string $helperText helper text
     * @param string $extraClassElement class tailwind tambahan untuk custom style element select
     * @param string $extraClassOptions class tailwind tambahan untuk custom style container element select
     * @param bool $isMultiple set true untuk multiple select
     * @param bool $hasSearch set true untuk menambahkan fitur pencarian
     * @param string $searchPlaceholder placeholder fitur pencarian, Note: Hanya berfungsi jika hasSearch=true
     * @param string $noResultText placeholder ketika data tidak ditemukan, Not : Hanya berfungsi jika hasSearch=true
     */
    public function __construct(string $keyId = 'select-advance',
                                string $label = 'label',
                                string $name = 'select-advance',
                                string $placeholder = 'placeholder',
                                ?array $options = null,
                                ?string $optionValue = '',
                                ?string $optionLabel = '',
                                array|string|null $selected = null,
                                string $helperText = 'helper text',
                                string $extraClassElement = '',
                                string $extraClassOptions = '',
                                bool $isMultiple = false,
                                bool $hasSearch = false,
                                string $searchPlaceholder = 'search placeholder',
                                string $noResultText = 'no result',
    )
    {
        $this->keyId = $keyId;
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->selected = $selected;
        $this->helperText = $helperText;
        $this->extraClassOptions = $extraClassOptions;
        $this->extraClassElement = $extraClassElement;
        $this->isMultiple = $isMultiple;
        $this->hasSearch = $hasSearch;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->noResultText = $noResultText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.advanced-select');
    }
}
