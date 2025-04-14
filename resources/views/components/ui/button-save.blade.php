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
                        confirmButton: "btn btn-soft btn-success",
                        cancelButton: "btn btn-soft btn-error"
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
