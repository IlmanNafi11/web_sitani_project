@extends('layouts.layout')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Kelompok Tani'" />
        </div>
        <form id="form-tambah-kelompok-tani" action="{{ route('kelompok-tani.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Kelompok Tani'" :name="'nama'" :placeholder="'Masukan nama kelompok tani'" />
                <x-form.advanced-select :name="'kecamatan_id'" :options="$kecamatans" :keyId="'kecamatan_id'"
                    :label="'Kecamatan'" :placeholder="'Pilih kecamatan'" :optionValue="'id'" :selected="null"
                    :optionLabel="'nama'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi desa dan penyuluh'" />
                <x-form.advanced-select :name="'desa_id'" :options="null" :keyId="'desa_id'" :label="'Desa'"
                    :placeholder="'Pilih desa'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'" />
                <x-form.advanced-select :name="'penyuluh_terdaftar_id[]'" :options="null" :keyId="'penyuluh_terdaftar_id'"
                    :label="'Penyuluh'" :placeholder="'Pilih penyuluh'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'" :isMultiple="true" :hasSearch="true" :searchPlaceholder="'Cari Penyuluh'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button-save formId="form-tambah-kelompok-tani" />
            </div>
        </form>
    </x-ui.card>
    <script>
        window.addEventListener('load', () => {
            async function getDesa(kecamatan_id) {
                try {
                    const response = await axios.get(`/kecamatan/${kecamatan_id}/desa`);
                    if (Array.isArray(response.data)) {
                        return response.data;
                    }

                    alert(response.data.message || 'Data desa tidak tersedia');
                    return [];
                } catch (error) {
                    console.error('Gagal mengambil data desa:', error);
                    return [];
                }
            }

            async function getPenyuluh(kecamatan_id) {
                try {
                    const response = await axios.get(`/kecamatan/${kecamatan_id}/penyuluh`);
                    if (Array.isArray(response.data)) {
                        return response.data;
                    }

                    alert(response.data.message || 'Data penyuluh tidak tersedia');
                    return [];
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

                    const currentOptions = Array.from(document.querySelector('#desa_id').options)
                        .map(opt => opt.value)
                        .filter(val => val !== '');

                    currentOptions.forEach(val => desaSelect.removeOption(val));

                    const currentOptionsPenyuluh = Array.from(document.querySelector('#penyuluh_terdaftar_id').options)
                        .map(opt => opt.val)
                        .filter(val => val !== '');

                    currentOptionsPenyuluh.forEach(val => penyuluhSelect.removeOption(val));

                    if (desaList.length > 0) {
                        const options = desaList.map(desa => ({
                            title: desa.nama,
                            val: desa.id.toString(),
                        }));
                        desaSelect.addOption(options);
                    }

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
