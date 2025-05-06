<div class="w-full {{ $extraClassElement ?? '' }}">
    <label class="label-text" for="{{ $keyId }}"> {{ $placeholder ?? 'Pilih File' }} </label>
    <input type="file" class="input pl-4! file:text-bg-soft-accent pr-0 @error($name) is-invalid @enderror"
           name="{{ $name }}" id="{{ $keyId }}" accept="{{ $accept }}"/>
    @if($helperText)
        <span id="helper-text-input-file" class="helper-text">{{ $helperText }}</span>
    @else
        <span id="helper-text-input-file" class="helper-text">{{ $message }}</span>
    @endif
</div>
