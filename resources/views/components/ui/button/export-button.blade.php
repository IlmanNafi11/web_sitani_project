@can($permission)
    <a href="{{ $routes }}" id="export-button" type="button"
       class="btn flex w-fit {{ $style ?? '' }} {{ $color ?? 'btn-primary' }} {{ $extraClassElement ?? '' }}">
        <span class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Button' }}
    </a>
@endcan
