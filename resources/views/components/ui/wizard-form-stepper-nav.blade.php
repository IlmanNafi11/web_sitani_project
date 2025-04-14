<ul class="relative flex flex-col gap-2 md:flex-row">
    @foreach ($attr as $attribute)
        <li class="group flex flex-1 flex-col items-center gap-2 md:flex-row" data-stepper-nav-item='@json($attribute)'>
        <span class="min-h-7.5 min-w-7.5 inline-flex flex-col items-center gap-2 align-middle text-sm md:flex-row">
            <span
                class="stepper-active:text-bg-primary stepper-active:shadow-sm shadow-base-300/20 stepper-success:text-bg-primary stepper-success:shadow-sm stepper-completed:text-bg-success stepper-error:text-bg-error text-bg-soft-neutral flex size-7.5 shrink-0 items-center justify-center rounded-full font-medium">
                <span class="stepper-success:hidden stepper-error:hidden stepper-completed:hidden text-sm">{{ $number++ }}</span>
                <span class="icon-[tabler--check] stepper-success:block hidden size-4 shrink-0"></span>
                <span class="icon-[tabler--x] stepper-error:block hidden size-4 shrink-0"></span>
            </span>
            <span class="text-base-content text-nowrap font-medium">
                {{ $attribute['title'] }}
            </span>
        </span>
        <div
            class="stepper-success:bg-primary stepper-completed:bg-success bg-base-content/20 h-px w-full group-last:hidden max-md:mt-2 max-md:h-8 max-md:w-px md:flex-1">
        </div>
    </li>
    @endforeach
</ul>
