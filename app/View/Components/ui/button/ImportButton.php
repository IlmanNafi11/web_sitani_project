<?php

namespace App\View\Components\ui\button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImportButton extends Component
{
    public string $title;
    public string $style;
    public string $icon;
    public string $extraClassElement;
    public string $color;
    public string $permission;
    public string $keyId;

    /**
     * @param string $title title button
     * @param string $style style button
     * @param string $icon icon button(opsional)
     * @param string $permission permission
     * @param string $color warna button
     * @param string $extraClassElement class tailwind tambahan untuk style custom button
     * @param string $keyId id button
     */
    public function __construct(string $title = 'Import',
                                string $style = 'btn-soft',
                                string $icon = 'icon-[line-md--file-import]',
                                string $permission = '',
                                string $color = 'btn-success',
                                string $extraClassElement = '',
                                string $keyId = 'btn-import',
    )
    {
        $this->title = $title;
        $this->style = $style;
        $this->icon = $icon;
        $this->permission = $permission;
        $this->color = $color;
        $this->extraClassElement = $extraClassElement;
        $this->keyId = $keyId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button.import-button');
    }
}
