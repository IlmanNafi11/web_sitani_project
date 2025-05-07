<div class="select-container w-full {{ $extraClassOption ?? '' }}">
    <label class="label-text" for="{{ $name ?? 'select-' . $label }}">{{ $label ?? 'Pilih Opsi' }}</label>
    <select class="select {{ $extraClassElement ?? '' }} @error($name) is-invalid @enderror"
            name="{{ $name }}"
            id="{{ $name ?? 'select-' . $label }}">
        <option value="" disabled {{ old($name, $selected) === null ? 'selected' : '' }}>
            {{ $placeholder ?? 'Pilih opsi...' }}
        </option>

        @foreach ($options as $option)
            @php
                $optionValueData = $option[$optionValue] ?? $option['id'];
                $isSelected = old($name) !== null
                                ? old($name) == $optionValueData
                                : $selected == $optionValueData;
            @endphp
            <option value="{{ $optionValueData }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $option[$optionLabel] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <span class="helper-text">{{ $message }}</span>
    @else
        <span class="helper-text">{{ $helperText ?? '' }}</span>
    @enderror
</div>
