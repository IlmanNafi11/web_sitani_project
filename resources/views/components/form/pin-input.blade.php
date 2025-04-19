<div class="flex space-x-3 w-full" data-pin-input='{"availableCharsRE": "^[0-9]+$"}'>
    @for ($i = 0; $i < 6; $i++)
        <input type="text"
               class="pin-input pin-input-underline focus:outline-none outline-none focus:ring-0 {{ $errors->has('otp') || $errors->has('otp.' . $i) ? 'border border-b-red-500! placeholder:text-red-500! text-red-500!' : '' }}"
               name="otp[]"
               placeholder="○"
               data-pin-input-item
               value="{{ old('otp.' . $i) }}" />
    @endfor
</div>

@if ($errors->has('otp'))
    <p class="text-red-500 text-sm mt-1">{{ $errors->first('otp') }}</p>
@else
    @for ($i = 0; $i < 6; $i++)
        @if ($errors->has('otp.' . $i))
            <p class="text-red-500 text-sm mt-1">{{ $errors->first('otp.' . $i) }}</p>
            @break
        @endif
    @endfor
@endif
