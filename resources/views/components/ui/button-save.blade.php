<button class="simpan-button btn btn-soft btn-accent"
    type="button" id="btn-simpan">
{{ $title ?? 'Simpan'}}</button>

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
