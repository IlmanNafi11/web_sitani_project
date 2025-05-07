<div class="accordion-item" id="{{ $keyId }}">
    <button class="accordion-toggle inline-flex items-center gap-x-4 text-start px-0" aria-controls="{{ $keyId }}-collapse" aria-expanded="false">
        <span class="icon-[tabler--chevron-right] accordion-item-active:rotate-90 size-5 shrink-0 transition-transform duration-300 rtl:rotate-180" ></span>
        {{ $title ?? 'title' }}
    </button>
    <div id="{{ $keyId }}-collapse" class="accordion-content hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="{{ $keyId }}" role="region">
        <div class="pb-2">
            <p class="text-base-content/80 font-normal text-sm">
                {{ $description ?? 'description' }}
            </p>
        </div>
    </div>
</div>
