<button class="simpan-button cursor-pointer bg-blue-600 hover:bg-blue-800 font-medium rounded-lg p-2.5 text-white flex gap-1"
    type="button" id="btn-simpan">
    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
            d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z" />
    </svg>
    <span>{{ $title ?? 'Simpan'}}</span>
</button>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('btn-simpan').addEventListener('click', (e) => {
                e.preventDefault();

                const sweetalert = Swal.mixin({
                    customClass: {
                        confirmButton: "btn-success cursor-pointer w-auto h-auto p-[12px] text-white bg-blue-600 rounded-lg ms-[8px]",
                        cancelButton: "btn-failed cursor-pointer w-auto h-auto p-[12px] text-white bg-red-600 rounded-lg me-[8px]"
                    },
                    buttonsStyling: false
                });
                sweetalert.fire({
                    title: "Simpan data?",
                    text: "Pastikan data telah di isi dengan benar!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Simpan",
                    cancelButtonText: "Tidak, Batal!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('{{ $formId }}').submit();
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        sweetalert.fire({
                            title: "Dibatalkan",
                            text: "Data tidak tersimpan",
                            icon: "info"
                        });
                    }
                });
            });
        });

    </script>
@endonce
