@extends('layouts.layout')
@section('title', 'Penyuluh | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Penyuluh'" />
            <x-ui.sub-title :title="'Manajemen Data Penyuluh yang Terdaftar di Dinas'" />
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
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('penyuluh-terdaftar.create')" :title="'Tambah Data'" :permission="'penyuluh.tambah'" /></div>`);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection

