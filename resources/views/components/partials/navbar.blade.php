<nav class="navbar w-full bg-base-100 border-b border-gray-200 sm:z-1 relative">
    <button type="button" class="btn btn-text max-sm:btn-square sm:hidden me-2" aria-haspopup="dialog"
        aria-expanded="false" aria-controls="with-navbar-sidebar" data-overlay="#with-navbar-sidebar">
        <span class="icon-[tabler--menu-2] size-5"></span>
    </button>
    <div class="flex flex-1 items-center">
        <a class="link text-base-content link-neutral text-3xl font-semibold no-underline" href="#" style="font-family: Marck Script">
            Sitani
        </a>
    </div>
    <div class="navbar-end flex items-center gap-4">
        <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
            <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center"
                aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                <div class="avatar">
                    <div class="size-9.5 rounded-full">
                        <picture>
                            <source srcset="{{ asset('storage/profile/profile.jpg') }}" type="image/jpeg"/>
                            <img src="{{ asset('storage/profile/profile.webp') }}" alt="avatar profil" />
                        </picture>
                    </div>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
                aria-labelledby="dropdown-avatar">
                <li class="dropdown-header gap-2">
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <picture>
                                <source srcset="{{ asset('storage/profile/profile.jpg') }}" type="image/jpeg" />
                                <img src="{{ asset('storage/profile/profile.webp') }}" alt="avatar profil" />
                            </picture>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-base-content text-base font-semibold">Afi</h6>
                        <small class="text-base-content/50">Admin</small>
                    </div>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <span class="icon-[tabler--user]"></span>
                        Profil Saya
                    </a>
                </li>
                <li class="dropdown-footer gap-2">
                    <a class="btn btn-error btn-soft btn-block" href="{{ route('login') }}">
                        <span class="icon-[tabler--logout]"></span>
                        Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
