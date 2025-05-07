<div id="{{ $keyId }}" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden [--overlay-backdrop:static] [--body-scroll:true] fixed inset-0 {{ $overlayBackdropColor ?? 'bg-base-content/60' }} overlay-backdrop" role="dialog" tabindex="-1">
    <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $title }}</h3>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
