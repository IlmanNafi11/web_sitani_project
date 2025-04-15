<div class="w-fit">
    <form id="form-delete-resource-{{ $keyId }}" action="{{ $route }}" method="post">
        @method('DELETE')
        @csrf
    </form>
    <button
        class="delete-button w-fit btn {{ $style ?? '' }} {{ $color ?? 'btn-primary' }} {{ $extraClassOption ?? '' }}"
        onclick="confirmDelete('{{$keyId}}')" type="button">
        <span class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Button' }}
    </button>
</div>

@once
    <script>
        function confirmDelete(id) {
            const sweetalert = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-soft btn-success",
                    cancelButton: "btn btn-soft btn-error"
                },
                buttonsStyling: false
            });
            sweetalert.fire({
                title: "Hapus data?",
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Tidak, Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-delete-resource-${id}`).submit();
                }
            });
        }
    </script>
@endonce
