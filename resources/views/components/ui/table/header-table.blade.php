<thead>
    <tr>
        @foreach ($items as $item)
            <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                <span class="flex items-center">
                    {{ $item['title'] }}
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                    </svg>
                </span>
            </th>
        @endforeach
    </tr>
</thead>
