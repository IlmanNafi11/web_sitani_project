@php
    $isDisable = $isDisable ?? false;
@endphp
<div class="text-input-container w-full {{ $extraClassOption ?? '' }}">
    <label class="label-text" for="{{ $keyId ?? 'input-' . $name}}">{{ $label ?? 'Label' }}</label>
    <input type="text" placeholder="{{ $placeholder ?? 'Masukan...'}}" class="input {{ $extraClassElement ?? '' }} @error($name)
        is-invalid
    @enderror" id="{{ $keyId ?? 'input-' . $name}}" name="{{ $name }}"
           value="{{ old($name, $defaultValue ?? '') }}" {{ $isDisable == true ? 'disabled' : '' }} />
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    @else
        <span class="helper-text">{{ $helperText ?? ''}}</span>
    @enderror
</div>
