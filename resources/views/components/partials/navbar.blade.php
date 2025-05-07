<nav class="navbar w-full bg-base-100 border-b border-gray-200 sm:z-1 relative">
    <button type="button" class="btn btn-text max-sm:btn-square sm:hidden me-2" aria-haspopup="dialog"
        aria-expanded="false" aria-controls="with-navbar-sidebar" data-overlay="#with-navbar-sidebar" data-overlay-options='{ "backdropExtraClasses": "!absolute transition duration-300 fixed inset-0 bg-base-content/60 overlay-backdrop"}'>
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
                <div class="avatar cursor-pointer">
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
                        <h6 class="text-base-content text-base font-semibold">{{ $user->admin->nama ?? $user->email }}</h6>
                        <small class="text-base-content/50">{{ $role->first() }}</small>
                    </div>
                </li>
                <li>
                    <a href="{{ route('profile.index') }}" id="btn-profil" class="dropdown-item cursor-pointer">
                        <span class="icon-[tabler--user]"></span>
                        Profil Saya
                    </a>
                </li>
                <li class="dropdown-footer gap-2">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="w-full">
                        @csrf
                        <button class="btn btn-error btn-soft btn-block" type="button" id="logout-btn">
                            <span class="icon-[tabler--logout]"></span>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Keluar dari aplikasi?",
                    text: "Anda yakin ingin keluar?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Ya, keluar",
                    cancelButtonText: "Tidak",
                    reverseButtons: true,
                    customClass: {
                        confirmButton: "btn btn-soft btn-error me-2",
                        cancelButton: "btn btn-soft btn-secondary"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        }
    });
</script>
