@extends('layouts.layout')
@section('content')
    <div class="kelompok-tani-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#E5E8EC] h-fit">
                    <div class="flex flex-col gap-4">
                        <div class="border-b border-[#E5E8EC]">
                            <span class="title-label-page font-medium mb-4 block">Perbarui Data Kelompok Tani</span>
                        </div>
                        <div class="form-container">
                            <form id="form-update-kelompok-tani" action="{{ route('kelompok-tani.update', $kelompokTanis->id) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="w-full grid grid-cols-1 md:grid-cols-2 grid-rows-3 md:grid-rows-2 gap-4 mb-4 md:mb-0">
                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="nama" class="@error('nama')
                                            text-red-600
                                        @enderror">Nama Kelompok Tani</label>
                                        <input
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                            placeholder="Masukan nama kelompok tani" type="text" id="nama" name="nama"
                                            value="{{ old('nama', $kelompokTanis->nama) }}">
                                        @error('nama')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="kecamatan_id" class="@error('kecamatan_id')
                                            text-red-600
                                        @enderror">Kecamatan</label>
                                        <div>
                                            <select id="kecamatan_id" name="kecamatan_id" data-select='{
                                                "placeholder": "Pilih kecamatan",
                                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                "toggleClasses": "advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                                "dropdownClasses": "advance-select-menu",
                                                "optionClasses": "advance-select-option selected:select-active",
                                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                                "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                                }' class="hidden">
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}" {{ $kelompokTanis->kecamatan->id == $kecamatan->id ? 'selected' : '' }}>
                                                    {{ $kecamatan->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="desa_id" class="@error('desa_id')
                                            text-red-600
                                        @enderror">Desa</label>
                                        <div>
                                            <select id="desa_id" name="desa_id" data-select='{
                                                "placeholder": "Pilih desa",
                                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                "toggleClasses": "add-option advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                                "dropdownClasses": "advance-select-menu",
                                                "optionClasses": "advance-select-option selected:select-active",
                                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                                "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                                }' class="hidden">
                                            </select>
                                        </div>
                                        <p id="helper-text-desa" class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mohon pilih kecamatan terlebih dahulu agar data desa tersedia.
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="penyuluh_terdaftar_id" class="@error('penyuluh_terdaftar_id')
                                            text-red-600
                                        @enderror">Penyuluh</label>
                                        <div>
                                            <select id="penyuluh_terdaftar_id" name="penyuluh_terdaftar_id[]" multiple data-select='{
                                            "placeholder": "Select multiple options...",
                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                            "toggleClasses": "advance-select-toggle select-disabled:pointer-events-none select-disabled:opacity-40",
                                            "dropdownClasses": "advance-select-menu",
                                            "optionClasses": "advance-select-option selected:select-active",
                                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                            "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                            }' class="hidden">
                                            </select>
                                        </div>

                                        @error('penyuluh_terdaftar_id')
                                            <p class="text-red-600">{{ $message }}</p>
                                            @else
                                            <p id="helper-text-penyuluh" class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mohon pilih kecamatan terlebih dahulu
                                            agar data penyuluh tersedia.
                                            </p>
                                        @enderror

                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-ui.button-save formId="form-update-kelompok-tani" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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
