@extends('layouts.layout')
@section('title', 'Kelompok Tani | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Kelompok Tani'" />
        </div>
        <form id="form-perbarui-kelompok-tani" action="{{ route('kelompok-tani.update', $kelompokTanis->id) }}"
            method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Kelompok Tani'" :name="'nama'" :placeholder="'Masukan nama kelompok tani'" :defaultValue="$kelompokTanis->nama" />
                <x-form.advanced-select :name="'kecamatan_id'" :options="$kecamatans" :keyId="'kecamatan_id'"
                    :label="'Kecamatan'" :placeholder="'Pilih kecamatan'" :optionValue="'id'" :selected="null"
                    :optionLabel="'nama'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi desa dan penyuluh'" :selected="$kelompokTanis->kecamatan->id" />
                <x-form.advanced-select :name="'desa_id'" :options="null" :keyId="'desa_id'" :label="'Desa'"
                    :placeholder="'Pilih desa'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'" />
                <x-form.advanced-select :name="'penyuluh_terdaftar_id[]'" :options="null" :keyId="'penyuluh_terdaftar_id'"
                    :label="'Penyuluh'" :placeholder="'Pilih penyuluh'" :helperText="'Pilih kecamatan terlebih dahulu untuk menampilkan opsi'" :isMultiple="true" :hasSearch="true" :searchPlaceholder="'Cari Penyuluh'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-perbarui-kelompok-tani" />
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
                    console.error('Gagal ambil desa:', error);
                    return [];
                }
            }

            async function getPenyuluh(kecamatan_id) {
                try {
                    const response = await axios.get(`/kecamatan/${kecamatan_id}/penyuluh`);
                    return Array.isArray(response.data) ? response.data : [];
                } catch (error) {
                    console.error('Gagal ambil penyuluh:', error);
                    return [];
                }
            }

            requestAnimationFrame(async () => {
                const kecamatanSelect = HSSelect.getInstance('#kecamatan_id');
                const desaSelect = HSSelect.getInstance('#desa_id');
                const penyuluhSelect = HSSelect.getInstance('#penyuluh_terdaftar_id');

                if (!kecamatanSelect || !desaSelect || !penyuluhSelect) return;

                const selectedKecamatanId = kecamatanSelect.value;
                const selectedDesaId = "{{ $kelompokTanis->desa->id ?? '' }}";
                const selectedPenyuluhIds = @json($kelompokTanis->penyuluhTerdaftars->pluck('id'));

                async function populateOptions() {
                    const desaList = await getDesa(selectedKecamatanId);
                    const penyuluhList = await getPenyuluh(selectedKecamatanId);

                    Array.from(document.querySelector('#desa_id').options).forEach(opt => desaSelect.removeOption(opt.value));
                    Array.from(document.querySelector('#penyuluh_terdaftar_id').options).forEach(opt => penyuluhSelect.removeOption(opt.value));

                    desaSelect.addOption(desaList.map(desa => ({
                        title: desa.nama,
                        val: desa.id.toString(),
                        selected: desa.id == selectedDesaId
                    })));

                    penyuluhSelect.addOption(penyuluhList.map(penyuluh => ({
                        title: penyuluh.nama,
                        val: penyuluh.id.toString(),
                        selected: selectedPenyuluhIds.includes(penyuluh.id)
                    })));
                }

                await populateOptions();

                kecamatanSelect.on('change', async () => {
                    const kecamatan_id = kecamatanSelect.value;
                    const desaList = await getDesa(kecamatan_id);
                    const penyuluhList = await getPenyuluh(kecamatan_id);

                    Array.from(document.querySelector('#desa_id').options).forEach(opt => desaSelect.removeOption(opt.value));
                    Array.from(document.querySelector('#penyuluh_terdaftar_id').options).forEach(opt => penyuluhSelect.removeOption(opt.value));

                    desaSelect.addOption(desaList.map(desa => ({
                        title: desa.nama,
                        val: desa.id.toString()
                    })));

                    penyuluhSelect.addOption(penyuluhList.map(penyuluh => ({
                        title: penyuluh.nama,
                        val: penyuluh.id.toString()
                    })));
                });
            });
        });
    </script>
@endsection
