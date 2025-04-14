<div>
    <div id="form-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden [--body-scroll:true]" role="dialog"
        tabindex="-1">
        <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ $titleModal ?? 'Title' }}</h3>
                    <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close"
                        data-overlay="#form-modal"><span class="icon-[tabler--x] size-4"></span></button>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
