<div class="flex flex-col gap-3 {{ $extraClassElement ?? ''}} join">
    <label for="{{ $keyId ?? 'number-counter-' . $name}}" class="label-text">{{ $label ?? 'Label'}}</label>
    <div class="relative flex items-center max-w-[8rem]">
        <button type="button" id="decrement-button" data-input-counter-decrement="{{ $name }}"
            class="join-item bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h16" />
            </svg>
        </button>
        <input type="text" id="{{ $keyId ?? 'number-counter-' . $name}}" name="{{ $name }}" data-input-counter data-input-counter-min="{{ $min ?? '1' }}"
            data-input-counter-max="{{ $max ?? '10' }}" aria-describedby="helper-text"
            class="join-item input h-full text-center"
            placeholder="{{ $min }}" value="{{ old($name, $defaultValue ?? '1') }}" />
        <button type="button" id="increment-button" data-input-counter-increment="{{ $name }}"
            class="join-item bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
        </button>
    </div>
    <p id="helper-text" class="helper-text mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $helperText ?? '' }}</p>
</div>
