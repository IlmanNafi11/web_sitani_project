<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WizardFormStepperNav extends Component
{
    public $attr;
    public $number;
    /**
     * Create a new component instance.
     */
    public function __construct($attr, $number)
    {
        $this->attr = $attr;
        $this->number = $number;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.wizard-form-stepper-nav');
    }
}
