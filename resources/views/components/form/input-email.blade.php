<div class="w-full h-auto {{ $extraClassOption ?? '' }}">
    <div class="input w-full {{ $extraClassElement ?? '' }}">
        <span
            class="{{ $icon ?? 'icon-[line-md--email-opened-multiple-twotone]' }} text-base-content/80 my-auto size-5 shrink-0"></span>
        <div class="input-floating grow">
            <input name="{{ $name }}" id="{{ $keyId ?? 'input-email-' . $name }}" type="email"
                placeholder="{{ $placeholder ?? 'Masukan...' }}" class="ps-3 w-full border-none outline-none focus:outline-none focus:ring-0" id="leadingIconFloating" value="{{ old($name) }}" />
            <label class="input-floating-label" for="leadingIconFloating">{{ $label ?? 'Label' }}</label>
        </div>
    </div>
    <span class="helper-text">{{ $helperText ?? '' }}</span>
</div>
