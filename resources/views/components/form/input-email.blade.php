@php
    $isFloatingLabel = $isFloatingLabel ?? true;
    $isDisabled = $isDisabled ?? false;
@endphp

@if($isFloatingLabel)
    <div class="w-full h-auto {{ $extraClassOption ?? '' }}">
        <div class="input w-full {{ $extraClassElement ?? '' }} @error($name) is-invalid @enderror">
        <span
            class="{{ $icon ?? 'icon-[line-md--email-opened-multiple-twotone]' }} text-base-content/80 my-auto size-5 shrink-0"></span>
            <div class="input-floating grow">
                <input name="{{ $name }}" id="{{ $keyId ?? 'input-email-' . $name }}" type="email"
                       placeholder="{{ $placeholder ?? 'Masukan...' }}"
                       class="ps-3 w-full border-none outline-none focus:outline-none focus:ring-0"
                       id="leadingIconFloating" value="{{ old($name, $defaultValue ?? '') }}" {{ $isDisabled === true ? 'disabled' : ''}} />
                <label class="input-floating-label" for="leadingIconFloating">{{ $label ?? 'Label' }}</label>
            </div>
        </div>
        @error($name)
        <p class="helper-text">{{ $message }}</p>
        @else
        <p id="helper-text" class="helper-text text-gray-500 dark:text-gray-400">{{ $helperText ?? ''}}
        </p>
        @enderror
    </div>
@endif

@if(!$isFloatingLabel)
    <div class="w-full {{ $extraClassOption ?? '' }}">
        <label class="label-text" for="{{ $keyId ?? 'input-phone-' . $name }}">{{ $label ?? 'Label' }}</label>
        <div class="input w-full pr-0 {{ $extraClassElement ?? '' }} @error($name)
        is-invalid
    @enderror">
        <span
            class="{{ $icon ?? 'icon-[line-md--email-opened-multiple-twotone]' }} text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
            <input type="email" class="grow outline-none border-none focus:outline-none focus:ring-0"
                   placeholder="{{ $placeholder ?? 'Masukan...' }}"
                   id="{{ $keyId ?? 'input-phone-' . $name }}" name="{{ $name }}"
                   value="{{ old($name, $defaultValue ?? '') }}" {{ $isDisabled === true ? 'disabled' : ''}} />
        </div>
        @error($name)
        <p class="helper-text">{{ $message }}</p>
        @else
        <p id="helper-text" class="helper-text text-gray-500 dark:text-gray-400">{{ $helperText ?? ''}}
        </p>
        @enderror
    </div>
@endif

