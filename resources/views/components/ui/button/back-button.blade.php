<button class="btn {{ $style ?? '' }} {{ $color ?? 'btn-secondary' }}" onclick="back()"><span class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Button' }}</button>
<script>
    function back() {
        history.back();
    }
</script>
