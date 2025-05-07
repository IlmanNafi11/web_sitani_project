<div class="text-area-container w-full {{ $extraClassOption ?? '' }}">
    <label class="label-text" for="{{ $keyId ?? 'text-area-' . $name}}">{{ $label ?? 'Text Area' }}</label>
    <textarea class="textarea {{ $extraClassElement ?? '' }} @error($name)
        is-invalid
    @enderror" placeholder="{{ $placeholder ?? 'Masukan teks disini...' }}" id="{{ $keyId ?? 'text-area-' . $name}}" name="{{ $name }}">{{ old($name, $defaultValue ?? '') }}</textarea>
    @error($name)
        <span class="helper-text">{{ $message }}</span>
        @else
        <span class="helper-text">{{ $helperText ?? ''}}</span>
    @enderror
</div>
