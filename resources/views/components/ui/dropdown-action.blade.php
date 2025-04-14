<div class="dropdown relative inline-flex">
    <button id="dropdown-default" type="button" class="dropdown-toggle btn btn-soft btn-accent" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        {{ $title ?? 'Dropdown'}}
        <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
    </button>
    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-default">
        {{ $slot }}
    </ul>
</div>
