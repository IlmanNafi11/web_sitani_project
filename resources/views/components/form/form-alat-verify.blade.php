<form id="form-verify-alat" action="{{route('laporan-alat.update', $laporan->id)}}" method="post" class="flex flex-col space-y-5">
    @method('PUT')
    @csrf
    <div class="input-container space-y-5">
        {{-- start info kelompok tani --}}
        <div id="info-kelompok-tani" class="space-y-5">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="nama-ketua-kelompok-tani">Nama Ketua Kelompok Tani</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Nama ketua kelompok tani" type="text" id="nama-ketua-kelompok-tani" name="nama-ketua-kelompok-tani"
                        value="{{ old('nama-ketua-kelompok-tani', $laporan->kelompokTani->nama_ketua) }}" disabled>
                </div>
                <div>
                    <label for="no-hp-ketua">No HP Ketua</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="No Hp Ketua Kelompok tani" type="text" id="no-hp-ketua" name="no-hp-ketua"
                        value="{{ old('no-hp-ketua', $laporan->kelompokTani->no_hp_ketua) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="npwp">NPWP</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="NPWP" type="text" id="npwp" name="npwp"
                        value="{{ old('npwp', $laporan->kelompokTani->npwp) }}" disabled>
                </div>
                <div>
                    <label for="email-kelompok-tani">Email Kelompok Tani</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Email Kelompok Tani" type="email" id="email-kelompok-tani" name="email-kelompok-tani"
                        value="{{ old('email-kelompok-tani', $laporan->kelompokTani->email) }}" disabled>
                </div>
            </div>
        </div>
        {{-- End info kelompok tani --}}

        {{-- start detail laporan --}}
        <div id="detail-laporan" class="space-y-5">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_ketua">KTP Ketua</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="KTP Ketua" type="text" id="path_ktp_ketua" name="path_ktp_ketua"
                        value="{{ old('path_ktp_ketua', $laporan->path_ktp_ketua) }}" disabled>
                </div>
                <div>
                    <label for="path_badan_hukum">Badan Hukum</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Badan Hukum" type="text" id="path_badan_hukum" name="path_badan_hukum"
                        value="{{ old('path_badan_hukum', $laporan->path_badan_hukum) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_piagam">Piagam</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Piagam" type="text" id="path_piagam" name="path_piagam"
                        value="{{ old('path_piagam', $laporan->path_piagam) }}" disabled>
                </div>
                <div>
                    <label for="path_surat_domisili">Surat Domisili</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Surat Domisili" type="text" id="path_surat_domisili" name="path_surat_domisili"
                        value="{{ old('path_surat_domisili', $laporan->path_surat_domisili) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_foto_lokasi">Foto Lokasi</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Foto Lokasi" type="text" id="path_foto_lokasi" name="path_foto_lokasi"
                        value="{{ old('path_foto_lokasi', $laporan->path_foto_lokasi) }}" disabled>
                </div>
                <div>
                    <label for="path_ktp_sekretaris">KTP Sekretaris</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="KTP Sekretaris" type="text" id="path_ktp_sekretaris" name="path_ktp_sekretaris"
                        value="{{ old('path_ktp_sekretaris', $laporan->path_ktp_sekretaris) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_ketua_upkk">KTP Ketua UPKK</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="KTP Ketua UPKK" type="text" id="path_ktp_ketua_upkk" name="path_ktp_ketua_upkk"
                        value="{{ old('path_ktp_ketua_upkk', $laporan->path_ktp_ketua_upkk) }}" disabled>
                </div>
                <div>
                    <label for="path_ktp_anggota1">KTP Anggota 1</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="KTP Anggota 1" type="text" id="path_ktp_anggota1" name="path_ktp_anggota1"
                        value="{{ old('path_ktp_anggota1', $laporan->path_ktp_anggota1) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_anggota2">KTP Anggota 2</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="KTP Anggota 2" type="text" id="path_ktp_anggota2" name="path_ktp_anggota2"
                        value="{{ old('path_ktp_anggota2', $laporan->path_ktp_anggota2) }}" disabled>
                </div>
            </div>
        </div>
        {{-- End detail laporan --}}
    </div>

    {{-- action button --}}
    <div class="button-group flex space-x-4">
        <button class="btn btn-soft btn-secondary" onclick="back()">Kembali</button>
        <x-ui.button.save-button :style="'btn-soft'" :formId="'form-verify-alat'" :title="'Verifikasi'"/>
    </div>
</form>
<script>
    function back(){
        history.back();
    }
</script>
