<button class="simpan-button btn {{ $style ?? '' }} {{ $color ?? 'btn-accent' }} {{ $extraClassElement ?? '' }}"
        type="button" id="btn-simpan"><span
        class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Simpan' }}</button>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('btn-simpan').addEventListener('click', (e) => {
                e.preventDefault();

                const fileInput = document.getElementById('{{ $inputId }}');
                const messageLabel = document.getElementById('helper-text-input-file');
                const form = document.getElementById('{{ $formId }}');

                if (!fileInput.files || fileInput.files.length === 0) {
                    messageLabel.innerHTML = 'Input file wajib diisi.';
                    fileInput.classList.add('is-invalid');
                    messageLabel.classList.add('is-invalid');
                    return;
                }

                const sweetalert = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-soft btn-success",
                        cancelButton: "btn btn-soft btn-error"
                    },
                    buttonsStyling: false
                });
                sweetalert.fire({
                    title: "{{ $titleAlert ?? 'Import data?' }}",
                    text: "{{ $messageAlert ?? 'Pastikan Data sudah sesuai dengan aturan yang ditetapkan' }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ $titleConfirmButton ?? 'Ya, Simpan' }}",
                    cancelButtonText: "{{ $titleCancelButton ?? 'Tidak, Batal!' }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

    </script>
@endonce
