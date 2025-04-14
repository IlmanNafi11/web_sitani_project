<form id="wizard-validation-form-horizontal" class="mt-5 sm:mt-8">

    <!-- start info kelompok tani -->
    <div id="account-details-validation" class="space-y-5" data-stepper-content-item='{ "index": 1 }'>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label-text" for="nama-kelompok-tani">Kelompok Tani</label>
                <input type="text" placeholder="Nama kelompok tani" class="input" id="nama-kelompok-tani" required />
            </div>
            <div>
                <label class="label-text" for="desa-kelompok-tani">Desa</label>
                <input type="text" placeholder="Desa kelompok tani" class="input" id="desa-kelompok-tani" required />
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label-text" for="kecamatan-kelompok-tani">Kecamatan</label>
                <input type="text" placeholder="kecamatan-kelompok-tani" class="input" id="kecamatan-kelompok-tani"
                    required />
            </div>
            <div>
                <label class="label-text" for="nama-komoditas">Komoditas</label>
                <input type="text" placeholder="nama komoditas" class="input" id="nama-komoditas" required />
            </div>
        </div>
    </div>
    <!-- End info kelompok tani -->

    <!-- start detail laporan -->
    <div id="personal-info-validation" class="space-y-5" data-stepper-content-item='{ "index": 2 }'
        style="display: none">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label-text" for="informasi-bibit">Bibit</label>
                <input type="text" placeholder="Bibit yang digunakan" class="input" id="informasi-bibit" required />
            </div>
            <div>
                <label class="label-text" for="luas-lahan">Luas lahan</label>
                <input type="text" placeholder="Luas lahan penanaman" class="input" id="luas-lahan" required />
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label-text" for="estimasi-panen">Estimasi Panen</label>
                <input type="text" placeholder="Estimasi panen" class="input" id="estimasi-panen" required />
            </div>
            <div>
                <label class="label-text" for="nama-penyuluh">Pelapor</label>
                <input type="text" placeholder="Nama penyuluh" class="input" id="nama-penyuluh" required />
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label-text" for="foto-bibit">Foto Bibit</label>
                <div class="relative min-w-8 max-w-96 h-60">
                    <div class="skeleton skeleton-animated absolute inset-0" id="skeleton-image-bibit"></div>
                    <img class="image-bibit w-full h-full object-cover rounded-md shadow absolute"
                        src="{{'/storage/foto_bibit/2/1744541905_Screenshot from 2025-04-09 06-42-49.png'}}"
                        alt="foto-bibit" onload="document.getElementById('skeleton-image-bibit').style.display='none';">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:flex md:flex-col">
                <div>
                    <label class="label-text" for="waktu-laporan">Waktu Laporan</label>
                    <input type="text" placeholder="Waktu laporan" class="input" id="waktu-laporan" required />
                </div>
                <div>
                    <label class="label-text" for="radio-verifikasi">Kualitas bibit</label>
                    <div class="flex flex-wrap gap-2">
                        <div class="flex items-center gap-1">
                            <input type="radio" name="status" class="radio radio-inset radio-success"
                                id="radio-berkualitas" />
                            <label class="label-text text-base" for="radio-berkualitas"> Berkualitas </label>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="radio" name="status" class="radio radio-inset radio-error"
                                id="radio-tidak-berkualitas" />
                            <label class="label-text text-base" for="radio-tidak-berkualitas"> Tidak Berkualitas
                            </label>
                        </div>
                    </div>
                    <span class="helper-text">Verifikasi kualitas bibit dengan memilih opsi yang tersedia</span>
                </div>
            </div>
        </div>
    </div>
    <!-- End detail laporan -->

    <!-- Button Group -->
    <div class="mt-5 flex items-center justify-between gap-y-2">
        <button type="button" class="btn btn-accent btn-prev max-sm:btn-square" data-stepper-back-btn="">
            <span class="icon-[tabler--chevron-left] text-primary-content size-5 rtl:rotate-180"></span>
            <span class="max-sm:hidden">Kembali</span>
        </button>
        <button type="button" class="btn btn-accent btn-next max-sm:btn-square" data-stepper-next-btn="">
            <span class="max-sm:hidden">Selanjutnya</span>
            <span class="icon-[tabler--chevron-right] text-primary-content size-5 rtl:rotate-180"></span>
        </button>
        <button type="button" class="btn btn-accent" data-stepper-finish-btn="" style="display: none">Simpan</button>
        <button type="reset" class="btn btn-accent" data-stepper-reset-btn="" style="display: none">Reset</button>
    </div>
</form>
