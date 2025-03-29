<div
    class="card {{ $width ?? 'w-full' }} {{ $height ?? 'h-auto' }} {{ $dropShadow ? 'shadow-sm' : ''}} bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-slate-400">
    {{ $slot }}
</div>
