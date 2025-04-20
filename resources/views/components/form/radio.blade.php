<div class="flex items-center gap-1 {{ $extraClassOption ?? '' }}">
    <input
        type="radio"
        name="{{ $name }}"
        id="{{ $keyId ?? 'radio-' . $name . '-' . ($value ?? '') }}"
        class="radio {{ $color ?? 'radio-primary' }} {{ $extraClassElement ?? '' }} @error($name) is-invalid @enderror"
        value="{{ $value ?? '' }}"
        @checked(
            (string)($checked ?? false) === 'true'
            || (old($name, $defaultValue ?? null) == $value)
        )
    />
    <label class="label-text text-base" for="{{ $keyId ?? 'radio-' . $name . '-' . ($value ?? '') }}">
        {{ $label ?? 'Label' }}
    </label>
</div>
