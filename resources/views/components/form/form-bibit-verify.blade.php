<form id="form-verify-bibit" action="{{route('laporan-bibit.update', $laporan->id)}}" method="post" class="flex flex-col space-y-5">
    @method('PUT')
    @csrf
    <div class="input-container space-y-5">
        {{-- start info kelompok tani --}}
        <div id="info-kelompok-tani" class="space-y-5">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="nama-kelompok-tani">Kelompok Tani</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Nama kelompok tani" type="text" id="nama-kelompok-tani" name="nama-kelompok-tani"
                        value="{{ old('nama-kelompok-tani', $laporan->kelompokTani->nama) }}" disabled>
                </div>
                <div>
                    <label for="desa-kelompok-tani">Desa</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Asal desa kelompok tani" type="text" id="desa-kelompok-tani" name="desa-kelompok-tani"
                        value="{{ old('desa-kelompok-tani', $laporan->kelompokTani->desa->nama) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="kecamatan-kelompok-tani">Kecamatan</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Asal kecamatan kelompok tani" type="text" id="kecamatan-kelompok-tanii"
                        name="kecamatan-kelompok-tani" value="{{ old('kecamatan-kelompok-tani', $laporan->kelompokTani->kecamatan->nama) }}" disabled>
                </div>
                <div>
                    <label for="komoditas">Komoditas</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Komoditas yang ditanam" type="text" id="komoditas" name="komoditas"
                        value="{{ old('komoditas', $laporan->komoditas->nama) }}" disabled>
                </div>
            </div>
        </div>
        {{-- End info kelompok tani --}}

        {{-- start detail laporan --}}
        <div id="detail-laporan" class="space-y-5">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="bibit">Bibit</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Bibit yang digunakan" type="text" id="bibit" name="bibit" value="{{ old('bibit', $laporan->laporanKondisiDetail->jenis_bibit) }}" disabled>
                </div>
                <div>
                    <label for="luas-lahan">Luas Lahan</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Luas lahan yang ditanam" type="text" id="luas-lahan" name="luas-lahan"
                        value="{{ old('luas-lahan', $laporan->laporanKondisiDetail->luas_lahan) . ' Hektar' }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="estimasi-panen">Estimasi Panen</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Estimasi panen" type="text" id="estimasi-panen" name="estimasi-panen"
                        value="{{ old('estimasi-panen', $laporan->laporanKondisiDetail->estimasi_panen) }}" disabled>
                </div>
                <div>
                    <label for="pelapor">Pelapor</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Nama penyuluh(pelapor)" type="text" id="pelapor" name="pelapor"
                        value="{{ old('pelapor', $laporan->penyuluh->penyuluhTerdaftar->nama) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="foto-bibit">Foto Bibit</label>
                    <div class="relative min-w-8 max-w-96 h-60">
                        <div class="skeleton skeleton-animated absolute inset-0" id="skeleton-image-bibit"></div>
                        <img class="image-bibit w-full h-full object-cover rounded-md shadow absolute cursor-not-allowed"
                            src="{{ asset('storage/' . $laporan->laporanKondisiDetail->foto_bibit)}}"
                            alt="foto-bibit" onload="document.getElementById('skeleton-image-bibit').style.display='none';" draggable="false">
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 md:flex md:flex-col">
                    <div>
                        <label for="waktu-laporan">Waktu Laporan</label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                            placeholder="Waktu laporan" type="text" id="waktu-laporan" name="waktu-laporan"
                            value="{{ old('waktu-laporan', $laporan->created_at) }}" disabled>
                    </div>
                    <div>
                        <label for="radio-verifikasi">Kualitas bibit</label>
                        <div class="flex flex-wrap gap-2">
                            <div class="flex items-center gap-1">
                                <input type="radio" name="status" class="radio radio-inset radio-success"
                                    id="radio-berkualitas" value="1" />
                                <label class="label-text text-base" for="radio-berkualitas"> Berkualitas </label>
                            </div>
                            <div class="flex items-center gap-1">
                                <input type="radio" name="status" class="radio radio-inset radio-error"
                                    id="radio-tidak-berkualitas" value="0"/>
                                <label class="label-text text-base" for="radio-tidak-berkualitas"> Tidak Berkualitas
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <p class="helper-text text-red-600">{{ $message }}</p>
                            @else
                            <span class="helper-text">Verifikasi kualitas bibit dengan memilih opsi yang tersedia</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        {{-- End detail laporan --}}
    </div>

    {{-- action button --}}
    <div class="button-group flex space-x-4">
        <button class="btn btn-soft btn-secondary" onclick="back()">Kembali</button>
        <x-ui.button.save-button :formId="'form-verify-bibit'" :title="'Verifikasi'"/>
    </div>
</form>
<script>
    function back(){
        history.back();
    }
</script>
