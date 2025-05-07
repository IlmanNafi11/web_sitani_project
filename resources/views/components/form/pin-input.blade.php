<div>
    <div class="flex space-x-3 w-full" data-pin-input='{"availableCharsRE": "^[0-9]+$"}'>
        @for ($i = 0; $i < 6; $i++)
            <input type="text"
                   class="pin-input pin-input-underline focus:outline-none outline-none focus:ring-0 {{ $errors->has('otp') || $errors->has('otp.' . $i) ? 'border border-b-red-500! placeholder:text-red-500! text-red-500!' : '' }}"
                   name="otp[]"
                   placeholder="○"
                   data-pin-input-item
                   value="{{ old('otp.' . $i) }}"/>
        @endfor
    </div>

    @if ($errors->has('otp'))
        <p class="text-red-500 text-sm mt-1">{{ $errors->first('otp') }}</p>
    @else
        @for ($i = 0; $i < 6; $i++)
            @if ($errors->has('otp.' . $i))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('otp.' . $i) }}</p>
                @break
            @endif
        @endfor
    @endif

    <div class="mt-4 text-center text-sm text-gray-600">
        <span class="helper-text inline">Tidak menerima OTP?
            <strong class="inline w-fit cursor-pointer link link-animated pl-1" id="resend-otp-btn">Kirim Ulang</strong>
        </span>
    </div>

    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('resend-otp-btn').addEventListener('click', function () {
                    this.innerHTML = 'Mengirim ulang...';

                    axios.post('{{ route('verifikasi-otp.resend') }}', {
                        _token: '{{ csrf_token() }}',
                    })
                        .then(function (response) {
                            Swal.fire({
                                title: "Berhasil",
                                text: "OTP berhasil dikirim. Silakan cek email Anda untuk menerima OTP baru.",
                                icon: "success",
                            });

                            document.getElementById('resend-otp-btn').innerHTML = 'Kirim Ulang';
                        })
                        .catch(function (error) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Gagal mengirim ulang OTP. Silakan coba lagi nanti.",
                                icon: "warning",
                            });

                            document.getElementById('resend-otp-btn').innerHTML = 'Kirim Ulang';
                        });
                });
            });
        </script>
    @endonce
</div>
