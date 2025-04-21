@extends('layouts.layout')
@section('title', 'Kecamatan | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Kecamatan'" />
            <x-ui.sub-title :title="'Manajemen Data Kecamatan di Nganjuk'" />
        </div>
        <table id="kecamatan-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Kecamatan'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($kecamatans as $kecamatan)
                    <tr class="text-black">
                        <td>{{ $kecamatan->nama }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'" :route="route('kecamatan.edit', $kecamatan->id)" :title="'Perbarui'" :permission="'kecamatan.ubah'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$kecamatan->id" :route="route('kecamatan.destroy', $kecamatan->id)" :permission="'kecamatan.hapus'" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>

        if (document.getElementById("kecamatan-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#kecamatan-table", {
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
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('kecamatan.create')" :title="'Tambah Data'" :permission="'kecamatan.tambah'" /></div>`);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection

