<div class="w-full {{ $extraClassOption ?? '' }}">
    <label class="label-text" for="{{ $keyId ?? 'input-phone-' . $name }}">{{ $label ?? 'Label' }}</label>
    <div class="input w-full pr-0 {{ $extraClassElement ?? '' }} @error($name)
        is-invalid
    @enderror">
        <span
            class="{{ $icon ?? 'icon-[line-md--phone-call]' }} text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
        <input type="text" class="grow outline-none border-none focus:outline-none focus:ring-0" placeholder="{{ $placeholder ?? 'Masukan...' }}"
            id="{{ $keyId ?? 'input-phone-' . $name }}" name="{{ $name }}"
            value="{{ old($name, $defaultValue ?? '') }}" />
    </div>
    @error($name)
        <p class="helper-text">{{ $message }}</p>

        @else

        <p id="helper-text" class="helper-text text-gray-500 dark:text-gray-400">{{ $helperText ?? ''}}
        </p>
    @enderror
</div>
