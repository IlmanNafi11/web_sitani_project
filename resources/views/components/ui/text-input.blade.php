<div class="text-input-container w-full h-24">

    @php
        $Typemode = [
            'normal' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 outline-none',
            'success' => 'bg-green-50 border border-green-500 text-green-900 dark:text-green-400 placeholder-green-700 dark:placeholder-green-500 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-green-500 outline-none',
            'error' => 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 outline-none'
        ];

    @endphp

    <label for="{{ $inputName }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $textLabel }}</label>
    <input type="{{ $inputType }}" id="{{ $inputName }}" class="{{ $Typemode[$mode] ?? 'normal'}}"
        placeholder="{{ $inputPlaceholder }}" />
    <p
        class="mt-2 text-sm font-medium {{ $mode == 'success' ? 'text-green-600 dark:text-green-500' : ($mode == 'error' ? 'text-red-600 dark:text-red-500' : 'text-gray-600 dark:text-gray-500') }} {{ $messageVisible ?? 'visible' }}">
        {{ $errorMessage ?? "" }}
    </p>

</div>
