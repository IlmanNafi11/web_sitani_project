<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public string $color;
    public string $icon;
    public string $style;
    public string $title;
    public Route $route;
    public string $keyId;
    public string $extraClassOption;
    public string $extraClassElement;
    public string $permission;

    /**
     * @param string $color warna button
     * @param string $icon icon button(opsional)
     * @param string $style style button
     * @param string $title title button
     * @param Route|null $route route
     * @param string $keyId id button
     * @param string $extraClassOption class tailwind tambahan untuk custom style kontainer button
     * @param string $extraClassElement class tailwind tambahan untuk custom style element button
     * @param string $permission permission
     */
    public function __construct(string $color = 'btn-error',
                                string $icon = 'icon-[solar--trash-bin-minimalistic-2-broken]',
                                string $style = 'btn-soft',
                                string $title = 'Hapus',
                                ?Route $route = null,
                                string $keyId = 'delete-button',
                                string $extraClassOption = '',
                                string $extraClassElement = '',
                                string $permission = '')
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->style = $style;
        $this->title = $title;
        $this->route = $route;
        $this->keyId = $keyId;
        $this->extraClassOption = $extraClassOption;
        $this->extraClassElement = $extraClassElement;
        $this->permission = $permission;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.delete-button');
    }
}
