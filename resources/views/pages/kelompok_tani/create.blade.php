@extends('layouts.layout')
@section('title', 'Kelompok Tani | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Kelompok Tani'"/>
        </div>
        <form id="form-tambah-kelompok-tani" action="{{ route('kelompok-tani.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Kelompok Tani'" :name="'nama'"
                                   :placeholder="'Masukan nama kelompok tani'"/>
                <x-form.advanced-select :name="'kecamatan_id'" :options="$kecamatans" :keyId="'kecamatan_id'"
                                        :hasSearch="true"
                                        :label="'Kecamatan'" :placeholder="'Pilih kecamatan'" :optionValue="'id'"
                                        :selected="null"
                                        :optionLabel="'nama'"
                                        :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi desa dan penyuluh'"/>
                <x-form.advanced-select :name="'desa_id'" :options="null" :keyId="'desa_id'" :label="'Desa'"
                                        :placeholder="'Pilih desa'"
                                        :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'"
                                        :hasSearch="true"/>
                <x-form.advanced-select :name="'penyuluh_terdaftar_id[]'" :options="null"
                                        :keyId="'penyuluh_terdaftar_id'"
                                        :label="'Penyuluh'" :placeholder="'Pilih penyuluh'"
                                        :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'"
                                        :isMultiple="true" :hasSearch="true" :searchPlaceholder="'Cari Penyuluh'"/>
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" :routes="'kelompok-tani.index'"/>
                <x-ui.button.save-button formId="form-tambah-kelompok-tani" :style="'btn-soft'"/>
            </div>
        </form>
    </x-ui.card>
    <script>
        window.addEventListener('load', () => {
            async function getDesa(kecamatan_id) {
                try {
                    const response = await axios.get(`/kecamatan/${kecamatan_id}/desa`);
                    return Array.isArray(response.data) ? response.data : [];
                } catch (error) {
                    console.error('Gagal mengambil data desa:', error);
                    return [];
                }
            }

            async function getPenyuluh(kecamatan_id) {
                try {
                    const response = await axios.get(`/kecamatan/${kecamatan_id}/penyuluh`);
                    return Array.isArray(response.data) ? response.data : [];
                } catch (error) {
                    console.error('Gagal mengambil data penyuluh', error);
                    return [];
                }
            }

            requestAnimationFrame(() => {
                const kecamatanSelect = HSSelect.getInstance('#kecamatan_id');
                const desaSelect = HSSelect.getInstance('#desa_id');
                const penyuluhSelect = HSSelect.getInstance('#penyuluh_terdaftar_id');

                if (!kecamatanSelect || !desaSelect || !penyuluhSelect) {
                    console.warn('HSSelect instance tidak ditemukan');
                    return;
                }

                kecamatanSelect.on('change', async () => {
                    const kecamatan_id = kecamatanSelect.value;

                    const desaList = await getDesa(kecamatan_id);
                    const penyuluhList = await getPenyuluh(kecamatan_id);

                    const desaOptionValues = Array.from(document.querySelector('#desa_id').options).map(opt => opt.value);
                    desaOptionValues.forEach(val => {
                        if (val !== '') desaSelect.removeOption(val);
                    });

                    if (desaList.length > 0) {
                        const options = desaList.map(desa => ({
                            title: desa.nama,
                            val: desa.id.toString(),
                        }));
                        desaSelect.addOption(options);
                    }

                    const penyuluhOptionValues = Array.from(document.querySelector('#penyuluh_terdaftar_id').options).map(opt => opt.value);
                    penyuluhOptionValues.forEach(val => {
                        if (val !== '') penyuluhSelect.removeOption(val);
                    });

                    if (penyuluhList.length > 0) {
                        const options = penyuluhList.map(penyuluh => ({
                            title: penyuluh.nama,
                            val: penyuluh.id.toString(),
                        }));
                        penyuluhSelect.addOption(options);
                    }
                });
            });
        });

    </script>
@endsection
