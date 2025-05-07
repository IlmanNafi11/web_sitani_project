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
                        value="{{ old('nama-ketua-kelompok-tani', $laporan->LaporanBantuanAlatDetail->nama_ketua) }}" disabled>
                </div>
                <div>
                    <label for="no-hp-ketua">No HP Ketua</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="No Hp Ketua Kelompok tani" type="text" id="no-hp-ketua" name="no-hp-ketua"
                        value="{{ old('no-hp-ketua', $laporan->LaporanBantuanAlatDetail->no_hp_ketua) }}" disabled>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="npwp">NPWP</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="NPWP" type="text" id="npwp" name="npwp"
                        value="{{ old('npwp', $laporan->LaporanBantuanAlatDetail->npwp) }}" disabled>
                </div>
                <div>
                    <label for="email-kelompok-tani">Email Kelompok Tani</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                        placeholder="Email Kelompok Tani" type="email" id="email-kelompok-tani" name="email-kelompok-tani"
                        value="{{ old('email-kelompok-tani', $laporan->LaporanBantuanAlatDetail->email) }}" disabled>
                </div>
            </div>
        </div>
        {{-- End info kelompok tani --}}

        <div id="detail-laporan" class="space-y-5">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_ketua">KTP Ketua</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_ktp_ketua)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_ktp_ketua) }}" alt="KTP Ketua" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div>
                    <label for="path_badan_hukum">Badan Hukum</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_badan_hukum)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_badan_hukum) }}" alt="Badan Hukum" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_piagam">Piagam</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_piagam)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_piagam) }}" alt="Piagam" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div>
                    <label for="path_surat_domisili">Surat Domisili</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_surat_domisili)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_surat_domisili) }}" alt="Surat Domisili" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_foto_lokasi">Foto Lokasi</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_foto_lokasi)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_foto_lokasi) }}" alt="Foto Lokasi" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div>
                    <label for="path_ktp_sekretaris">KTP Sekretaris</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_ktp_sekretaris)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_ktp_sekretaris) }}" alt="KTP Sekretaris" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_ketua_upkk">KTP Ketua UPKK</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_ktp_ketua_upkk)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_ktp_ketua_upkk) }}" alt="KTP Ketua UPKK" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <div>
                    <label for="path_ktp_anggota1">KTP Anggota 1</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_ktp_anggota1)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_ktp_anggota1) }}" alt="KTP Anggota 1" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_ktp_anggota2">KTP Anggota 2</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_ktp_anggota2)
                        <img src="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_ktp_anggota2) }}" alt="KTP Anggota 2" class="w-full h-auto">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="path_proposal">Proposal (PDF)</label>
                    @if($laporan->LaporanBantuanAlatDetail->path_proposal)
                        <a href="{{ asset('storage/' . $laporan->LaporanBantuanAlatDetail->path_proposal) }}" target="_blank" class="text-blue-500">View Proposal (PDF)</a>
                    @else
                        <p>No proposal available</p>
                    @endif
                </div>
            </div>
        </div>
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
