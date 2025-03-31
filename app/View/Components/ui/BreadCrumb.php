<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumb extends Component
{
    public array $breadcrumbs;

    /**
     * Komponen breadcrumbs
     *
     * @param array $breadcrumbs item breadcrumb. contoh: ['name' => 'Beranda', 'url' => route('nama-routing')]
     */
    public function __construct(array $breadcrumbs)
    {
        $this->$breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components..ui.bread-crumb');
    }
}
