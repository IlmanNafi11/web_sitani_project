<div>
    <form id="form-delete-resource-{{ $id }}" action="{{ route($route, $id) }}" method="post">
        @method('DELETE')
        @csrf
    </form>
    <button
        class="delete-button cursor-pointer flex gap-1 justify-center items-center font-medium w-fit h-auto bg-red-600 hover:bg-red-800 rounded-md p-3 text-white" onclick="confirmDelete('{{$id}}')" type="button">
        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
        <span>{{ $title ?? 'Hapus' }}</span>
    </button>
</div>

@once
    <script>
        function confirmDelete(id) {
            const sweetalert = Swal.mixin({
                customClass: {
                    confirmButton: "btn-success cursor-pointer w-auto h-auto p-[12px] text-white bg-blue-600 rounded-lg ms-[8px]",
                    cancelButton: "btn btn-failed cursor-pointer w-auto h-auto p-[12px] text-white bg-red-600 rounded-lg me-[8px]"
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
