<div class="w-full {{ $extraClassElement ?? '' }}">
    <label class="label-text" for="{{ $keyId }}"> {{ $title ?? 'Pilih File' }} </label>
    <input type="file" class="input pl-4! file:text-bg-soft-accent pr-0 @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $keyId }}" accept=".xlsx"/>
    @error($name)
    <span class="helper-text">{{ $message }}</span>
    {{--    @else--}}
    <span class="helper-text">{{ $helperText ?? ''}}</span>
    @enderror
</div>
