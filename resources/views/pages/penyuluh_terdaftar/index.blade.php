@extends('layouts.layout')
@section('title', 'Penyuluh | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.table.import-failed-table/>
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Penyuluh'" />
            <x-ui.sub-title :title="'Manajemen Data Penyuluh yang Terdaftar di Dinas'" />
        </div>
        <div id="file-action-container">
            <x-ui.dropdown-action :title="'File'" :color="'btn-secondary'">
                <x-ui.button.export-button :title="'Unduh Template'" :style="'btn-soft'" :color="'btn-secondary'"
                                           :routes="route('penyuluh-terdaftar.download')" :permission="'penyuluh.lihat'"
                                           :extra-class-element="'w-full'" :icon="'icon-[line-md--file-download]'" />
                <x-ui.button.export-button :title="'Export Excel'" :style="'btn-soft'" :color="'btn-success'"
                                           :routes="route('penyuluh-terdaftar.export')" :permission="'penyuluh.export'"
                                           :extra-class-element="'w-full'" :icon="'icon-[line-md--file-export]'" />
                <x-ui.button.import-button :title="'Import Excel'" :style="'btn-soft'" :color="'btn-info'"
                                           :permission="'penyuluh.import'" :extra-class-element="'w-full'"
                                           :keyId="'import-modal'" :icon="'icon-[line-md--file-import]'" />
            </x-ui.dropdown-action>
        </div>
        <table id="penyuluh-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Penyuluh'],
        ['title' => 'No Hp'],
        ['title' => 'Alamat'],
        ['title' => 'Kecamatan'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($penyuluhs as $penyuluh)
                    <tr class="text-black">
                        <td>{{ $penyuluh->nama }}</td>
                        <td>{{ $penyuluh->no_hp }}</td>
                        <td>{{ $penyuluh->alamat }}</td>
                        <td>{{ $penyuluh->kecamatan->nama }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'" :route="route('penyuluh-terdaftar.edit', $penyuluh->id)" :title="'Perbarui'" :permission="'penyuluh.ubah'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$penyuluh->id" :route="route('penyuluh-terdaftar.destroy', $penyuluh->id)" :permission="'penyuluh.hapus'" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
        <x-ui.modal :title="'Import Data Penyuluh'" :keyId="'import-modal'">
            <form id="import-form" action="{{ route('penyuluh-terdaftar.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-0">
                    <x-form.file-input :keyId="'import-file'" :name="'file'"
                                       :helper-text="'Pastikan Format cslx, xls'" :accept="'.xlsx, .xls'"/>
                </div>
                <div class="modal-footer">
                    <x-ui.button.cancel-import-button :dataOverlay="'import-modal'" :inputId="'import-file'" :labelId="'helper-text-input-file'" />
                    <x-ui.button.submit-import-button :title="'Import'" :color="'btn-success'" :formId="'import-form'"
                                             :style="'btn-soft'"
                                             :message-alert="'Pastikan data telah sesuai dengan aturan yang tertera'"
                                             :title-alert="'Impor Data?'" :title-confirm-button="'Ya'"
                                             :title-cancel-button="'Batal'" :inputId="'import-file'"/>
                </div>
            </form>
        </x-ui.modal>
    </x-ui.card>
    <script>

        if (document.getElementById("penyuluh-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#penyuluh-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: true,
                searcable: true,
                labels: {
                    placeholder: "Cari data",
                    searchTitle: "Search within table",
                    pageTitle: "Page {page}",
                    perPage: "Data per halaman",
                    noRows: "Data Kosong",
                    info: "Menampilkan {start} sampai {end} dari {rows} data",
                    noResults: "Data tidak ditemukan",
                },
            });

            $(document).ready(function () {
                const dataTable = $(".datatable-top");
                dataTable.prepend(`<div id="action-header-container" class="action-header-container flex gap-2.5"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('penyuluh-terdaftar.create')" :title="'Tambah Data'" :permission="'penyuluh.tambah'" /></div>`);
                dataTable.children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');

                const fileActionContainer = document.getElementById('file-action-container');
                const actionHeaderContainer = document.getElementById('action-header-container');

                if (fileActionContainer && actionHeaderContainer) {
                    actionHeaderContainer.appendChild(fileActionContainer);
                }
            });
        }
    </script>
@endsection

