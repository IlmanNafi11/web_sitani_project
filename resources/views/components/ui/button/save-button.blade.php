<button class="simpan-button btn {{ $style ?? '' }} {{ $color ?? 'btn-accent' }} {{ $extraClassElement ?? '' }}" type="button" id="btn-simpan"><span
        class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Simpan' }}</button>

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
                    title: "{{ $titleAlert ?? 'Simpan data?' }}",
                    text: "{{ $messageAlert ?? 'Pastikan data telah di isi dengan benar!' }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ $titleConfirmButton ?? 'Ya, Simpan' }}",
                    cancelButtonText: "{{ $titleCancelButton ?? 'Tidak, Batal!' }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('{{ $formId }}').submit();
                    }
                });
            });
        });

    </script>
@endonce
