<div class="w-full h-auto {{ $extraClassOption ?? '' }}">
    <div class="input w-full {{ $extraClassElement ?? '' }}">
        <span
            class="{{ $icon ?? 'icon-[solar--lock-password-broken]' }} text-base-content/80 my-auto size-5 shrink-0"></span>
        <div class="input-floating grow">
            <input id="{{ $keyId ?? 'toggle-password-' . $name }}" type="password"
                placeholder="{{ $placeholder ?? 'Masukan...' }}" value="{{ old($name) }}" class="ps-3 w-full border-none outline-none focus:outline-none focus:ring-0" />
            <label class="input-floating-label"
                for="{{ $keyId ?? 'toggle-password-' . $name }}">{{ $label ?? 'Label' }}</label>
        </div>
        <button type="button" data-toggle-password='{ "target": "#{{ $keyId ?? 'toggle-password-' . $name }}" }'
            class="block cursor-pointer" aria-label="password toggle">
            <span class="icon-[tabler--eye] text-base-content/80 password-active:block hidden size-5 shrink-0"></span>
            <span
                class="icon-[tabler--eye-off] text-base-content/80 password-active:hidden block size-5 shrink-0"></span>
        </button>
    </div>
    @error($name)
    <p class="helper-text">{{ $message }}</p>
    @else
        <p id="helper-text" class="helper-text text-gray-500 dark:text-gray-400">{{ $helperText ?? ''}}
        </p>
        @enderror
</div>
