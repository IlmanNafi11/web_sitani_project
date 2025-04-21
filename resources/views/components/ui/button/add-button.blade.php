@can($permission)
    <a href="{{ $route }}" id="edit-button" type="button"
       class="btn w-fit {{ $style ?? '' }} {{ $color ?? 'btn-primary' }} {{ $extraClassOption ?? ''}}">
        <span class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Button' }}
    </a>
@endcan
