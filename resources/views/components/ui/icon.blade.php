<span class="inline-block {{ $position ?? 'static'}}" style="width: {{ $size ?? 24}}px; height: {{ $size ?? 24 }}px; color: {{ $color ?? 'currentColor'}};">
    <span class="w-full h-full block">
        {{ $slot }}
    </span>
</span>
