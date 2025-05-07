<x-ui.card>
    <div class="flex space-x-6 justify-between">
        <div class="stat-container flex flex-col gap-2 max-sm:gap-1">
            <span class="block text-wrap">{{ $title ?? 'title' }}</span>
            <span class="block text-2xl font-bold">{{ $stats ?? 'value' }}</span>
        </div>
        <div class="icon-container flex justify-center items-center">
            <div class="size-13 max-sm:size-11 p-2.5 box-border {{ $iconColor ?? 'text-bg-soft-secondary' }} border rounded-lg ">
                <span class="{{ $icon ?? 'icon-[streamline--interface-signal-graph-heart-line-beat-square-graph-stats]' }} size-full shrink-0"></span>
            </div>
        </div>
    </div>
</x-ui.card>
