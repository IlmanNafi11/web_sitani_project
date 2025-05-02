@extends('layouts.layout')
@section('title', 'Komoditas | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.table.import-failed-table />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Komoditas'" />
            <x-ui.sub-title :title="'Manajemen Data Komoditas pertanian di Nganjuk'" />
        </div>
        <div id="file-action-container">
            <x-ui.dropdown-action :title="'File'" :color="'btn-secondary'">
                <x-ui.button.export-button :title="'Unduh Template'" :style="'btn-soft'" :color="'btn-secondary'" :routes="route('komoditas.download')" :permission="'komoditas.lihat'" :extra-class-element="'w-full'" :icon="'icon-[line-md--file-download]'" />
                <x-ui.button.export-button :title="'Export Excel'" :style="'btn-soft'" :color="'btn-success'" :routes="route('komoditas.export')" :permission="'komoditas.export'" :extra-class-element="'w-full'" :icon="'icon-[line-md--file-export]'" />
                <x-ui.button.import-button :title="'Import Excel'" :style="'btn-soft'" :color="'btn-info'" :permission="'komoditas.import'" :extra-class-element="'w-full'" :keyId="'import-modal'" :icon="'icon-[line-md--file-import]'" />
            </x-ui.dropdown-action>
        </div>
        <table id="komoditas-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Komoditas'],
        ['title' => 'Jumlah Musim/Tahun'],
        ['title' => 'Deskripsi'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($datas as $komoditas)
                    <tr class="text-black">
                        <td>{{ $komoditas->nama }}</td>
                        <td>{{ $komoditas->musim }}</td>
                        <td>{{ $komoditas->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'" :route="route('komoditas.edit', $komoditas->id)" :title="'Perbarui'" :permission="'komoditas.ubah'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$komoditas->id" :route="route('komoditas.destroy', $komoditas->id)" :permission="'komoditas.hapus'" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
        <x-ui.modal :title="'Import Data Komoditas'" :keyId="'import-modal'" >
            <form id="import-form" action="{{ route('komoditas.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-0">
                    <x-form.file-input :keyId="'import-file'" :name="'file'" :helper-text="'Pastikan Format cslx, xls'" :accept="'.xlsx, .xls'" />
                </div>
                <div class="modal-footer">
                    <x-ui.button.cancel-import-button :dataOverlay="'import-modal'" :inputId="'import-file'" :labelId="'helper-text-input-file'" />
                    <x-ui.button.submit-import-button :title="'Import'" :color="'btn-success'" :formId="'import-form'" :style="'btn-soft'" :message-alert="'Pastikan data telah sesuai dengan aturan yang tertera'" :title-alert="'Impor Data?'" :title-confirm-button="'Ya'" :title-cancel-button="'Batal'" :inputId="'import-file'" />
                </div>
            </form>
        </x-ui.modal>
    </x-ui.card>
    <script>

        if (document.getElementById("komoditas-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#komoditas-table", {
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
                dataTable.prepend(`<div id="action-header-container" class="action-header-container flex gap-2.5"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('komoditas.create')" :title="'Tambah Data'" :permission="'komoditas.tambah'" /></div>`);
                dataTable.children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');

                const fileActionContainer = document.getElementById('file-action-container');
                const actionHeaderContainer = document.getElementById('action-header-container');

                if (fileActionContainer && actionHeaderContainer) {
                    actionHeaderContainer.appendChild(fileActionContainer);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
@endsection
