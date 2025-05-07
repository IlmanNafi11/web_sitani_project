<div class="flex flex-col {{ $extraClassOptions ?? '' }}">
    <label for="{{ $keyId ?? 'advance-select-' . $name }}" class="label-text">{{ $label ?? 'Label' }}</label>
    <div>
        @php
            $isMultiple = $isMultiple ?? false;
            $selected = $selected ?? ($isMultiple ? [] : null);
            $hasSearch = $hasSearch ?? false;

            $shouldPlaceholderBeSelected = !$isMultiple && (old($name, $selected) === null);
        @endphp
        <select id="{{ $keyId ?? 'advance-select-' . $name }}" name="{{ $name }}{{ $isMultiple ? '[]' : '' }}"
                {{ $isMultiple ? 'multiple' : '' }}
                data-select='{
                "placeholder": "{{ $placeholder ?? 'Pilih opsi' }}",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "add-option advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                "hasSearch": {{ $hasSearch ? 'true' : 'false' }},
                "searchPlaceholder": "Cari {{ $searchPlaceholder ?? '' }}",
                "searchNoResultText": "{{ $noResultText ?? 'Opsi tidak ditemukan' }}",
                "searchClasses": "border-base-content/40 focus:border-primary focus:outline-primary bg-base-100 block w-full rounded-field border px-3 py-2 text-base focus:outline-1",
                "dropdownClasses": "advance-select-menu max-h-44 overflow-y-auto",
                "optionClasses": "advance-select-option selected:select-active",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
            }' class="@error($name)
            is-invalid
            @enderror hidden">
            <option value="" disabled {{ $shouldPlaceholderBeSelected ? 'selected' : '' }}>
                {{ $placeholder ?? 'Pilih opsi' }}
            </option>

            @if ($options)
                @foreach ($options as $option)
                    @php
                        $optionValueData = $option[$optionValue] ?? $option['id'];

                        $isOptionSelected = false;
                        $oldValue = old($name);
                        $currentSelected = $selected;

                        if ($oldValue !== null) {
                            if ($isMultiple) {
                                $isOptionSelected = is_array($oldValue) && in_array($optionValueData, $oldValue);
                            } else {
                                $isOptionSelected = $oldValue == $optionValueData;
                            }
                        } elseif ($currentSelected !== null) {
                            if ($isMultiple) {
                                $isOptionSelected = is_array($currentSelected) && in_array($optionValueData, $currentSelected);
                            } else {
                                $isOptionSelected = $currentSelected == $optionValueData;
                            }
                        }
                    @endphp
                    <option value="{{ $optionValueData }}" {{ $isOptionSelected ? 'selected' : '' }}>
                        {{ $option[$optionLabel] }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    @error($name)
    <p class="helper-text">{{ $message }}</p>

    @else
    <p id="helper-text" class="helper-text text-gray-500 dark:text-gray-400">
        {{ $helperText ?? '' }}
    </p>
    @enderror
</div>
