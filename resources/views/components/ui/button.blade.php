<div>
    @php
        $baseClass = "focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2";
        $colors = [
            'red' => 'bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
            'yellow' => 'bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900',
            'purple' => 'bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900',
            'blue' => 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900'
        ];
        $buttonClass = $baseClass . " " . ($colors[$color] ?? $colors['blue']);
    @endphp

    <button type="button" class="{{ $buttonClass }} {{$width ?? 'w-auto'}}">
        <div class="{{ $contentStyle ?? 'flex gap-3 justify-center items-center'}}">
            {{ $slot }}
            <span class="{{ $titleStyle ?? 'text-lg font-bold' }}">{{ $title ?? 'Button'}}</span>
        </div>
    </button>

</div>
