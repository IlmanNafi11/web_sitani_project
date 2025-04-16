<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdvancedSelect extends Component
{
    public $keyId;
    public $label;
    public $name;
    public $placeholder;
    public $options;
    public $optionValue;
    public $optionLabel;
    public $selected;
    public $helperText;
    public $extraClassOptions;
    public $extraClassElement;
    public $isMultiple;
    public $hasSearch;
    public $searchPlaceholder;
    public $noResultText;


    public function __construct($keyId, $label, $name, $placeholder, $options, $optionValue, $optionLabel, $selected, $helperText, $extraClassElement, $extraClassOptions, $isMultiple, $hasSearch, $searchPlaceholder, $noResultText)
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
