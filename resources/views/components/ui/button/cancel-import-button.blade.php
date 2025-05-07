<button id="btn-cancel" type="button" class="btn {{ $style ?? 'btn-soft' }} {{ $color ?? 'btn-secondary' }}"
        data-overlay="#{{ $dataOverlay }}"><span
        class="{{ $icon ?? 'hidden'}} size-4.5 shrink-0"></span> {{ $title ?? 'Tutup' }} </button>
@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const label = document.getElementById('{{ $labelId }}');
            const inputFile = document.getElementById('{{ $inputId }}');

            document.getElementById('btn-cancel').addEventListener('click', () => {
                label.innerHTML = 'Pastikan Format cslx, xls';
                label.classList.remove('is-invalid');
                inputFile.classList.remove('is-invalid');
            });
        })
    </script>
@endonce
