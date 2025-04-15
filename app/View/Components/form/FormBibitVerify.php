<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormBibitVerify extends Component
{
    public $laporan;
    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..form.form-bibit-verify');
    }
}
