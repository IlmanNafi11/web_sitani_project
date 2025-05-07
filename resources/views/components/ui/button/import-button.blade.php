@can($permission)
    <button type="button" class="btn {{ $style ?? '' }} {{ $color ?? 'btn-success' }} {{ $extraClassElement ?? '' }}"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="{{ $keyId }}"
            data-overlay="#{{ $keyId }}"><span class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span>{{ $title }}</button>
@endcan
